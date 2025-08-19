<?php

namespace App\Http\Controllers\Billboard;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\ClientCompany;
use App\Models\User;
use App\Models\Billboard;
use App\Models\BillboardBooking;
use App\Models\MonthlyOngoingJob;
use App\Models\BillboardImage;
use App\Models\State;
use App\Models\District;
use App\Models\Location;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PushNotificationController;
use Illuminate\Support\Facades\Log;

class BillboardBookingController extends Controller
{
    public $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /**
     * Show the booking page.
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('billboard.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any project. Contact system admin for access !');
        }

        $companies = ClientCompany::orderBy('name', 'ASC')->get();
        $states = State::orderBy('name', 'ASC')->get();
        $districts = District::orderBy('name', 'ASC')->get();
        $locations = Location::rightJoin('billboards', 'billboards.location_id' , 'locations.id')
        ->orderBy('name', 'ASC')->get();

        return view('billboard.booking.index', compact('companies', 'states', 'districts', 'locations'));
    }

    /**
     * Show the on going work order list.
     */
    public function list(Request $request)
    {
        $user = Auth::user();

        // Get user roles
        $role = $user->roles->pluck('name')[0];

        $userID = $this->user->id;

        $columns = array(
            0 => 'site_number',
            1 => 'company_name',
            2 => 'location',
            3 => 'start_date',
            4 => 'end_date',
            5 => 'duration',
            6 => 'status',
            7 => 'remarks',
            8 => 'id',
        );

        $limit              = $request->input('length');
        $start              = $request->input('start');
        $orderColumnIndex   = $request->input('order.0.column');
        $orderColumnName    = $columns[$orderColumnIndex];
        $orderDirection     = $request->input('order.0.dir');

        $filters = $this->extractFilters($request);

        $query = $this->baseBookingQuery();

        $this->applyBookingFilters($query, $filters);

        // Get total records count
        $totalData = $query->count();

        // Search (same as other endpoint)
        if (!empty($filters['search_value'])) {
            $searchValue = trim(strtolower($filters['search_value']));
            $query->where(function ($q) use ($searchValue) {
                $q->where('billboards.site_number', 'LIKE', "%{$searchValue}%")
                ->orWhere('client_companies.name', 'LIKE', "%{$searchValue}%")
                ->orWhere('locations.name', 'LIKE', "%{$searchValue}%")
                ->orWhere('districts.name', 'LIKE', "%{$searchValue}%")
                ->orWhere('states.name', 'LIKE', "%{$searchValue}%");
            });
        }

        $query->orderBy('billboard_bookings.id', 'desc');

        

        // Get total filtered records count
        $totalFiltered = $query->count();

        // Apply pagination
        $filteredData = $query->skip($start)->take($limit)->get();

        $data = array();

        foreach ($filteredData as $d) {
            $created_at = Carbon::parse($d->created_at)->format('Y-m-d');

            $nestedData = array(
                'site_number'           => $d->site_number,
                'company_id'            => $d->company_id,
                'company_name'          => $d->company_name,
                'location_id'           => $d->location_id,
                'location_name'         => $d->location_name,
                'start_date'            => $d->start_date ? Carbon::parse($d->start_date)->format('d/m/y') : null,
                'end_date'              => $d->end_date ? Carbon::parse($d->end_date)->format('d/m/y') : null,
                'remarks'               => $d->remarks,
                'duration'              => ($d->start_date && $d->end_date) ? Carbon::parse($d->start_date)->diffInMonths(Carbon::parse($d->end_date)) + 1 : null,
                'created_at'            => $created_at,
                'status'                => $d->status,
                'id'                    => $d->id,
            );

            $data[] = $nestedData;
        }

        $json_data = array(
            "draw"              => intval($request->input('draw')),
            "recordsTotal"      => intval($totalData),
            "recordsFiltered"   => intval($totalFiltered),
            "data"              => $data,
        );

        return response()->json($json_data);
    }

    /**
     * Create Monthly Ongoing Billboard Booking
     */
    public function create(Request $request)
    {   
        $user = Auth::user();
        
        // Get user roles
        $role = $user->roles->pluck('name')[0];
        $userID = $this->user->id;

        $location           = $request->location;
        $client            = $request->client;
        $start_date         = $request->start_date;
        $end_date           = $request->end_date;
        $status             = $request->status;
        $artwork_by         = $request->artwork_by;
        $dbp_approval       = $request->dbp_approval;
        $remarks            = $request->remarks;

        try {

            DB::beginTransaction();
            
            $billboard_id = Billboard::where('location_id', $location)->value('id');

            if (!$billboard_id) {
                return response()->json(['error' => 'Billboard not found for the selected location.'], 404);
            }

            // Check for overlapping bookings
            $overlap = BillboardBooking::where('billboard_id', $billboard_id)
                ->where(function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('start_date', [$start_date, $end_date])
                        ->orWhereBetween('end_date', [$start_date, $end_date])
                        ->orWhere(function ($query2) use ($start_date, $end_date) {
                            $query2->where('start_date', '<=', $start_date)
                                    ->where('end_date', '>=', $end_date);
                        });
                })
                ->exists();

            if ($overlap) {
                return response()->json(['error' => 'This billboard is already booked for the selected date range.'], 409);
            }

            //Create a new service request
            $booking = BillboardBooking::create([
                'billboard_id'      => $billboard_id,
                'company_id'        => $client,
                'start_date'        => $start_date,
                'end_date'          => $end_date,
                'status'            => $status,
                'artwork_by'        => $artwork_by,
                'dbp_approval'      => $dbp_approval,
                'remarks'           => $remarks,
            ]);

            $booking->save();

            DB::commit();

            return response()->json([
                'success'   => 'success',
            ], 200);

        }catch (\Exception $e) {
            // If any queries fail, undo all changes
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Edit Monthly Ongoing Billboard Booking
     */
    public function edit(Request $request)
    {

        $booking_id   = $request->booking_id;
        $status       = $request->status;
        $remarks      = $request->remarks;
        
        //Validation rules
        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'original_workOrder_id' => [
        //             'required',
        //             'string',
        //             'max:700',
        //             Rule::exists('work_order','id')->whereNot('status', 'VERIFICATION_PASSED'),
        //             Rule::exists('work_order','id')->whereNot('priority', $priority),
        //         ],
        //         'priority' => [
        //             'required',
        //             'string',
        //             'in: 1,2,3,4',
        //             // Rule::exists('work_order')->where(fn($query)=>
        //             //     $query->where('id', $original_workOrder_id) 
        //             //         ->where('priority', '!=', $priority) 
                        
        //             // ),
        //             // Rule::exists('work_order')->where('id', $original_workOrder_id),
        //             //'exists:work_order,priority,id,' . $original_workOrder_id . '0',
        //         ],
        //     ],

        //     [
        //         'original_workOrder_id.exists' => 'Work order is not allowed to be edited in VERIFICATION_PASSED phse',

        //         'priority.required' => 'The "Priority" field is required.',
        //         'priority.in'       => 'The value of "Priority" field is incorrect.',
        //         //'priority.exists'   => 'The "Priority" field is no change',
        //     ],
        // );

        // Handle failed validations
        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()->first()], 422);
        // }
        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Retrieve the WorkOrder and related ServiceRequest
            $id = BillboardBooking::findOrFail($booking_id);

            logger('idnya apaan: ' . $id);

            // Update work order
            BillboardBooking::where('id', $id->id)
                ->update([
                    'status'        => $status,
                    'remarks'       => $remarks,
                    'updated_at'    => Carbon::now(),
                ]);

            // Ensure all queries successfully executed, commit the db changes
            DB::commit();

            return response()->json([
                "success"   => "success",
            ], 200);
        } 
        catch (\Exception $e) {
            // If any queries fail, undo all changes
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Delete billboard booking
     */
    public function delete(Request $request)
    {   
        $user = Auth::user();
        
        // // Get user roles
        $role = $user->roles->pluck('name')[0];
        $userID = $this->user->id;

        $id = $request->id;

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // delete billboard booking
            BillboardBooking::where('id', $id)->delete();

            // Ensure all queries successfully executed, commit the db changes
            DB::commit();

            return response()->json([
                "success"   => "success",
            ], 200);
        } catch (\Exception $e) {
            // If any queries fail, undo all changes
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function downloadPdf($id)
    {
        // $billboard = Billboard::with(['location.district.state', 'images'])->findOrFail($id);

        $billboard = Billboard::with([
            'location' => function ($query) {
                $query->with([
                    'district' => function ($query) {
                        $query->with('state');
                    }
                ]);
            },
            'billboard_images'
        ])->findOrFail($id);

        $pdf = PDF::loadView('billboard.export', compact('billboard'))
        ->setPaper('A4', 'landscape'); // 👈 Set orientation here

        return $pdf->download('billboard-detail-' . $billboard->site_number . '.pdf');
    }

    public function exportListPdf(Request $request)
    {
        $query = Billboard::with(['location.district.state', 'billboard_images']);

        if ($request->filled('state_id') && $request->state_id !== 'all') {
            $query->whereHas('location.district.state', fn($q) => $q->where('id', $request->state_id));
        }

        if ($request->filled('district_id') && $request->district_id !== 'all') {
            $query->whereHas('location.district', fn($q) => $q->where('id', $request->district_id));
        }

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('size') && $request->size !== 'all') {
            $query->where('size', $request->size);
        }

        $billboards = $query->get();

        // Get filename based on state or district
        $filename = 'billboards-master';
        $date = Carbon::now()->format('Y-m-d');

        if ($request->filled('district_id') && $request->district_id !== 'all') {
            $district = District::find($request->district_id);
            if ($district) {
                $filename = 'billboards-' . Str::slug($district->name) . '-' . $date;
            }
        } elseif ($request->filled('state_id') && $request->state_id !== 'all') {
            $state = State::find($request->state_id);
            if ($state) {
                $filename = 'billboards-' . Str::slug($state->name) . '-' . $date;
            }
        } else {
            $filename .= '-' . $date;
        }

        $pdf = PDF::loadView('billboard.exportlist', compact('billboards'))
            ->setPaper('a4', 'landscape');

        return $pdf->download($filename . '.pdf');
    }













    public function getMonthlyOngoingJobs(Request $request)
    {
        $filters = $this->extractFilters($request);
        $orderColumn = $request->input('order.0.column', 'id'); 
        $orderDir    = $request->input('order.0.dir', 'desc');

        $query = $this->baseBookingQuery();

        $this->applyBookingFilters($query, $filters);

        // search (same as DataTable)
        if (!empty($filters['search_value'])) {
            $searchValue = trim(strtolower($filters['search_value']));
            $query->where(function ($q) use ($searchValue) {
                $q->where('billboards.site_number', 'LIKE', "%{$searchValue}%")
                ->orWhere('client_companies.name', 'LIKE', "%{$searchValue}%")
                ->orWhere('locations.name', 'LIKE', "%{$searchValue}%")
                ->orWhere('districts.name', 'LIKE', "%{$searchValue}%")
                ->orWhere('states.name', 'LIKE', "%{$searchValue}%");
            });
        }

        // order (use DataTable column mapping)
        $columns = [
            0 => 'billboards.site_number',
            1 => 'client_companies.name',
            2 => 'locations.name',
            3 => 'billboard_bookings.start_date',
            4 => 'billboard_bookings.end_date',
            5 => 'duration', // virtual
            6 => 'billboard_bookings.status',
            7 => 'billboard_bookings.remarks',
            8 => 'billboard_bookings.id',
        ];

        $orderColumnIndex = $filters['order_column_index'] ?? 8; // default to id
        $orderColumnName = $columns[$orderColumnIndex] ?? 'billboard_bookings.id';
        $orderDir = $filters['order_dir'] ?? 'desc';

        $query->orderBy($orderColumnName, $orderDir)
            ->orderBy('billboard_bookings.id', 'desc');


        $jobs = $query->get();

        $data = [];

        foreach ($jobs as $job) {
            $start = Carbon::parse($job->start_date);
            $end = Carbon::parse($job->end_date);
            $duration = $start->diffInDays($end) + 1;

            $months = array_fill(1, 12, '');

            $monthStatuses = MonthlyOngoingJob::where('booking_id', $job->id)
                ->where('year', $filters['year'])
                ->pluck('status', 'month');

            foreach ($monthStatuses as $month => $status) {
                $months[$month] = $status;
            }

            $data[] = [
                'id' => $job->id,
                'client' => $job->clientCompany->name ?? '',
                'location' => $job->billboard->location->name ?? '',
                'type' => $job->billboard->type ?? '',
                'start_date' => $job->start_date ? Carbon::parse($job->start_date)->format('d/m/y') : null,
                'end_date' => $job->end_date ? Carbon::parse($job->end_date)->format('d/m/y') : null,
                'duration' => ($job->start_date && $job->end_date) ? Carbon::parse($job->start_date)->diffInMonths(Carbon::parse($job->end_date)) + 1 : null,
                'months' => array_values($months),
            ];
        }

        return response()->json(['data' => $data]);
    }

    private function extractFilters(Request $request)
    {
        return [
            'client'      => $request->input('client'),
            'start_date'  => $request->filled('start_date') ? Carbon::parse($request->input('start_date'))->format('Y-m-d') : null,
            'end_date'    => $request->filled('end_date') ? Carbon::parse($request->input('end_date'))->format('Y-m-d') : null,
            'year'       => $request->input('year', now()->year),
            'state'      => $request->input('state'),
            'district'   => $request->input('district'),
            'location'   => $request->input('location'),
            'type'       => $request->input('type'),
            'status'     => $request->input('status'),
            'search_value' => $request->input('search.value'),
            'order_column_index' => $request->input('order.0.column'),
            'order_dir' => $request->input('order.0.dir', 'desc'),
        ];
    }

    private function baseBookingQuery()
    {
        return BillboardBooking::select(
            'billboard_bookings.*',
            'billboards.site_number as site_number',
            'client_companies.name as company_name',
            'locations.id as location_id',
            'locations.name as location_name',
            'districts.id as district_id',
            'districts.name as district_name',
            'states.id as state_id',
            'states.name as state_name'
        )
        ->leftJoin('client_companies', 'client_companies.id', '=', 'billboard_bookings.company_id')
        ->leftJoin('billboards', 'billboards.id', '=', 'billboard_bookings.billboard_id')
        ->leftJoin('locations', 'locations.id', '=', 'billboards.location_id')
        ->leftJoin('districts', 'districts.id', '=', 'locations.district_id')
        ->leftJoin('states', 'states.id', '=', 'districts.state_id');
    }


    private function applyBookingFilters($query, $filters)
    {
        logger('hoho: ' , $filters);
        return $query
            ->when(!empty($filters['start_date']) && !empty($filters['end_date']), function ($q) use ($filters) {
                $q->where(function ($sub) use ($filters) {
                    $sub->where('billboard_bookings.start_date', '<=', $filters['end_date'])
                        ->where('billboard_bookings.end_date', '>=', $filters['start_date']);
                });
            })
            ->when(!empty($filters['state']), fn($q) => $q->where('states.id', $filters['state']))
            ->when(!empty($filters['district']), fn($q) => $q->where('districts.id', $filters['district']))
            ->when(!empty($filters['location']), fn($q) => $q->where('locations.id', $filters['location']))
            ->when(!empty($filters['status']), fn($q) => $q->where('billboard_bookings.status', $filters['status']))
            ->when(!empty($filters['client']), fn($q) => $q->where('billboard_bookings.company_id', $filters['client']));
    }


















































    public function updateJobMonthlyStatus(Request $request)
    {
        
        $request->validate([
            'id' => 'required|exists:billboard_bookings,id',
            'status' => 'nullable|string',
        ]);

        $year = $request->input('year', now()->year);
        $booking_id = $request->id;
        $month = $request->month;
        $status = $request->status;

        if (empty($status)) {
            MonthlyOngoingJob::where('booking_id', $booking_id)
                ->where('month', $month)
                ->where('year', 2025)
                ->delete();

            return response()->json(['message' => 'Status cleared']);
        }

        MonthlyOngoingJob::updateOrCreate(
            [
                'booking_id' => $booking_id,
                'month' => $month,
                'year' => 2025,
                'status' => $status,
            ],
        );

        return response()->json(['message' => 'Status updated']);
    }

























    

    

    /**
     * Update status of work order
     */
    public function update(Request $request){

        $statusUpdated = $request->update_status;

        logger('status updatedd: '. $statusUpdated);

        //Point to relevant function based on the new work order status need to assign 
        if($statusUpdated == 'STARTED') {
            $result = $this->updateStatus_AssignTechnician($request) ;

        } elseif($statusUpdated == 'COMPLETED') {
            $result = $this->updateStatus_Completed($request) ;

        } else {
            return response()->json(['error' => 'Incorrect process or no value is applied.' ], 422); 
        }
         
        return $result;
    }

    

    /**
     * View billboard details
     */
    public function redirectNewTab(Request $request)
    {

        $filter = $request->input('filter');
        $id = $request->input('id');
        
        $billboard_detail = Billboard::leftJoin('locations', 'locations.id', 'billboards.location_id')
            ->leftJoin('districts', 'districts.id', '=', 'locations.district_id')
            ->leftJoin('states', 'states.id', '=', 'districts.state_id')
            ->leftJoin('billboard_images', 'billboard_images.billboard_id', 'billboards.id')
            ->select(
                'billboards.*',
                'locations.name as location_name',
                'districts.name as district_name',
                'states.name as state_name',
                'billboard_images.image_path as billboard_image'
            )
            ->where('billboards.id', $request->id)
            ->first();

        $billboard_images = BillboardImage::where('billboard_id', $request->id)->get();


            logger('bb details: ' . $billboard_detail);

            // Convert to Dubai time
            // $dubaiTime = Carbon::parse($open_WO_DetailId->created_dt);

            // Add new formatted date, month, and year fields to the object
            // $open_WO_DetailId->created_dt = $dubaiTime->format('F j, Y \a\t g:i A');

        // if ($open_WO_DetailId !== null) {

        //     $woActivities = WorkOrderActivity::select(
        //         'work_order_activity.id as comment_id',
        //         'comments',
        //         'comment_by',
        //         'work_order_activity.created_at as created_at',
        //         'name',
        //     )
        //     ->leftJoin('users', 'users.id', 'work_order_activity.comment_by')
        //     ->where('work_order_id', '=', $request->id);

            // if($filter){
            //     if ($filter == 'new') {
            //         $woActivities->orderBy('created_at', 'desc');
            //     } elseif ($filter == 'old'){
            //         $woActivities->orderBy('created_at', 'asc');
            //     }
            // }
            // // ->get();

            // $woActivities = $woActivities->get();

            // $woActivities->transform(function ($woActivity) {
            //     // Convert to Dubai time
            //     $created_dt = Carbon::parse($woActivity->created_at);
    
            //     // Add new formatted date, month, and year fields to the object
            //     $woActivity->created_dt = $created_dt->format('F j, Y \a\t g:i A');

            //     // Fetch related attachments
            //     $attachments = WorkOrderActivityAttachment::select('id', 'url')
            //     ->where('wo_activity_id', '=', $woActivity->comment_id)
            //     ->get();

            //     // Add attachments to the activity
            //     $woActivity->attachments = $attachments;
    
            //     return $woActivity;
            // });

            // $gg = $woActivities->get();

            // $WoOrHistory = WorkOrderHistory::select(
            //     'work_order_history.id',
            //     'work_order_history.status',
            //     'work_order_history.status_changed_by',
            //     'work_order_history.assigned_teamleader',
            //     'work_order_history.assign_to_technician',
            //     'users.id as user_id',
            //     'users.name as user_name',
            // )
            // ->leftJoin('users', 'users.id', '=', DB::raw('CASE 
            //         WHEN work_order_history.status = "NEW" THEN work_order_history.status_changed_by 
            //         WHEN work_order_history.status = "ACCEPTED" THEN work_order_history.status_changed_by 
            //         WHEN work_order_history.status = "ASSIGNED_SP" THEN work_order_history.status_changed_by                     
            //         WHEN work_order_history.status = "ACCEPTED_TECHNICIAN" THEN work_order_history.assign_to_technician
            //         WHEN work_order_history.status = "STARTED" THEN work_order_history.assign_to_technician
            //         WHEN work_order_history.status = "COMPLETED" THEN work_order_history.assign_to_technician
            //         ELSE NULL 
            //     END'))
            // ->where('work_order_history.work_order_id', '=', $request->id)
            // ->get();

            // return view('workOrderProfile.index', compact('open_WO_DetailId', 'imageData', 'WoOrObImageBefore', 'WoOrObImageAfter', 'WoOrHistory'));
            return view('billboard.detail', compact('billboard_detail', 'billboard_images'));
            
        // } else {
        //     // Handle the case when no record is found
        //     // You can return an error message or redirect the user
        //     return response()->json(['error' => 'No record found with the provided ID'], 404);
        // }
    }

    

    
}