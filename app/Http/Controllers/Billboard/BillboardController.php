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
use App\Models\State;
use App\Models\District;
use App\Models\Location;

use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PushNotificationController;
use Illuminate\Support\Facades\Log;

class BillboardController extends Controller
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
     * Show the projects page.
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('billboard.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any project. Contact system admin for access !');
        }
        // $type = Project::distinct()->get(['type']);
        // return view('projects.index', compact('type'));

        $states = State::orderBy('name', 'ASC')->get();
        $districts = District::orderBy('name', 'ASC')->get();
        $locations = Location::orderBy('name', 'ASC')->get();
        $billboardTypes = Billboard::select('type', 'prefix')->distinct()->pluck('type', 'prefix');
        $billboardStatus = Billboard::distinct()->pluck('status');
        $billboardSize = Billboard::distinct()->pluck('size');
        $billboardLighting = Billboard::distinct()->pluck('lighting');

        // return view('workOrder.index', compact('clientcompany', 'projects', 'supervisors', 'technicians'));
        return view('billboard.index', compact('states', 'districts', 'locations', 'billboardTypes', 'billboardStatus', 'billboardSize', 'billboardLighting'));
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

        // determine user role
        // $isTechnician = in_array($role, ["employee_technician"]) && $user->status == 1;
        // $isAdmin = in_array($role, ["superadmin", "team_leader"]) && $user->status == 1;

        $status = $request->input('status');
        $state = $request->input('state');
        $district = $request->input('district');
        $type     = $request->input('type');
        $size     = $request->input('size');

        $columns = array(
            0 => 'site_number',
            1 => 'type',
            2 => 'size',
            3 => 'lighting',
            4 => 'location_name',
            5 => 'district_name',
            6 => 'date_registered',
            7 => 'status',
            8 => 'id',
            9 => 'id',
        );

        $limit              = $request->input('length');
        $start              = $request->input('start');
        $orderColumnIndex   = $request->input('order.0.column');
        $orderColumnName    = $columns[$orderColumnIndex];
        $orderDirection     = $request->input('order.0.dir');

        $query = Billboard::select('billboards.*', 'locations.id as location_id', 'locations.name as location_name', 'districts.id as district_id', 'districts.name as district_name', 'states.id as state_id', 'states.name as state_name')
            ->leftJoin('locations', 'billboards.location_id', '=', 'locations.id')
            ->leftJoin('districts', 'locations.district_id', '=', 'districts.id')
            ->leftJoin('states', 'districts.state_id', '=', 'states.id')
            ->orderBy($orderColumnName, $orderDirection);

        // Superadmin permission
        // if($isAdmin){
        //     if($teamleader != 'all' && $teamleader != 'none'){
        //         $query = $query->where('work_order.assigned_teamleader', $teamleader);
        //     }elseif($teamleader == 'none'){
        //         $query = $query->whereNull('work_order.assigned_teamleader');
        //     }

        //     if($technician != 'all' && $technician != 'none'){
        //         $query = $query->where('work_order.assign_to_technician', $technician);
        //     }elseif($technician == 'none'){
        //         $query = $query->where('work_order.assign_to_technician', $technician);
        //     }
        // }

        // Technician permission
        // if($isTechnician){
        //     $query = $query->where('work_order.assign_to_technician', $userID);
        // }

        if ($status != "all") {
            $query->where('billboards.status', $status);
        }

        if ($state != "all") {
            $query->where('states.id', $state);
        }

        if ($district != "all") {
            $query->where('districts.id', $district);
        }

        if ($type != "all") {
            $query->where('billboards.type', $type);
        }

        if ($size != "all") {
            $query->where('billboards.size', $size);
        }

        // Get total records count
        $totalData = $query->count();

        $searchValue = trim(strtolower($request->input('search.value')));

        if (!empty($searchValue)) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('billboards.site_number', 'LIKE', "%{$searchValue}%");
            });
        }

        // Get total filtered records count
        $totalFiltered = $query->count();

        // Apply pagination
        $filteredData = $query->skip($start)->take($limit)->get();

        $data = array();

        foreach ($filteredData as $d) {
            $created_at = Carbon::parse($d->created_at)->format('Y-m-d');

            $nestedData = array(
                'site_number'           => $d->site_number,
                'type'                  => $d->type,
                'size'                  => $d->size,
                'lighting'              => $d->lighting,
                'location_id'           => $d->location_id,
                'state_id'              => $d->state_id,
                'district_id'           => $d->district_id,
                'location_name'         => $d->location_name,
                'region'                => $d->district_name . ', ' . $d->state_name,
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
     * Create service request and work order.
     */
    public function create(Request $request)
    {   
        $user = Auth::user();
        
        // Get user roles
        $role = $user->roles->pluck('name')[0];
        $userID = $this->user->id;

        logger('masuk sini3');

        $type               = $request->type;
        $size               = $request->size;
        $lighting           = $request->lighting;
        $state              = $request->state;
        $district           = $request->district;
        $location           = $request->location;
        $gpslongitude       = $request->gpslongitude;
        $gpslatitude        = $request->gpslatitude;
        $trafficvolume      = $request->trafficvolume;

        // Get the current UTC time
        $current_UTC = Carbon::now('UTC');

        DB::beginTransaction();

        try {
            // Step 1: Fetch state code from state model (assuming you have it)
            $stateCode = State::select('prefix')->where('id', $state)->first();

            // Step 2: Count existing records for the same type and state to get the next number
            $runningNumber = Billboard::leftJoin('locations', 'billboards.location_id', '=', 'locations.id')
            ->leftJoin('districts', 'locations.district_id', '=', 'districts.id')
            ->leftJoin('states', 'districts.state_id', '=', 'states.id')
            ->where('states.id', $state)
            ->count() + 1;

            $billboardType = Billboard::select('type', 'prefix')->distinct()->where('prefix' , $type)->first();

            // Format as 4-digit number with leading zeros
            $formattedNumber = str_pad($runningNumber, 4, '0', STR_PAD_LEFT);

            // Step 3: Set status character
            $statusChar = 'A'; // or use: $status == 1 ? 'A' : 'I'

            // Step 4: Generate site_number
            $siteNumber = "{$type}-{$stateCode->prefix}-{$formattedNumber}-{$statusChar}";

            //Create a new service request
            $billboard = Billboard::create([
                'site_number'      => $siteNumber,
                'status'            => 1,
                'type'              => $billboardType->type,
                'prefix'              => $billboardType->prefix,
                'size'              => $size,
                'lighting'          => $lighting,
                'state'             => $state,
                'district'          => $district,
                'location_id'          => $location,
                'gps_longitude'      => $gpslongitude,
                'gps_latitude'       => $gpslatitude,
                'traffic_volume'     => $trafficvolume,
                'created_by'        => $userID,
            ]);

            // Generate the service request no & work order no based on prefixes and count
            // $getPrefixNo = $billboard->billboardPrefixNo();

            // Generate the service request number based on prefixes and count
            // $billboard->service_request_no = $getPrefixNo[0];
            $billboard->save();

            // Validate the input
            // $validator = Validator::make($request->all(), [
            //     'priority' => 'required|in:1,2,3,4', // Priority must be one of the three values
            //     ]);
        
            //     if ($validator->fails()) {
            //     return response()->json(['error' => $validator->errors()->first()], 422);
            //     }
        

        

            // $pushNotificationController = new PushNotificationController();
            // $pushNotificationController->sendEmailNewSR($serviceRequest, $workOrder);

            // Ensure all queries successfully executed, commit the db changes
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
     * Edit work order.
     */
    public function edit(Request $request)
    {

        //Check the permission to edit the work order 
        if (!$this->user->can('work_order.edit')) {
            return response()->json(['error' => 'Sorry !! You are Unauthorized to edit work order. Contact system admin for access !'], 403);
        }

        // Get the current UTC time
        $current_UTC = Carbon::now('UTC');

        $original_workOrder_id   = $request->original_workOrder_id;
        $priority                = $request->priority;
        
        //Validation rules
        $validator = Validator::make(
            $request->all(),
            [
                'original_workOrder_id' => [
                    'required',
                    'string',
                    'max:700',
                    Rule::exists('work_order','id')->whereNot('status', 'VERIFICATION_PASSED'),
                    Rule::exists('work_order','id')->whereNot('priority', $priority),
                ],
                'priority' => [
                    'required',
                    'string',
                    'in: 1,2,3,4',
                    // Rule::exists('work_order')->where(fn($query)=>
                    //     $query->where('id', $original_workOrder_id) 
                    //         ->where('priority', '!=', $priority) 
                        
                    // ),
                    // Rule::exists('work_order')->where('id', $original_workOrder_id),
                    //'exists:work_order,priority,id,' . $original_workOrder_id . '0',
                ],
            ],

            [
                'original_workOrder_id.exists' => 'Work order is not allowed to be edited in VERIFICATION_PASSED phse',

                'priority.required' => 'The "Priority" field is required.',
                'priority.in'       => 'The value of "Priority" field is incorrect.',
                //'priority.exists'   => 'The "Priority" field is no change',
            ],
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Retrieve the WorkOrder and related ServiceRequest
            $workOrder = WorkOrder::findOrFail($original_workOrder_id);
            $serviceRequest = ServiceRequest::findOrFail($workOrder->service_request_id);

            // Get the created_at timestamp from ServiceRequest
            $createdAt = Carbon::parse($serviceRequest->created_at);
            

                // Set due_date based on priority
                switch ($priority) {
                    case '1':
                        $dueDate = $createdAt->addDays(15)->toDateTimeString(); // Add 5 days for Low priority
                        break;
                    case '2':
                        $dueDate = $createdAt->addDays(30)->toDateTimeString(); // Add 3 days for Medium priority
                        break;
                    case '3':
                        $dueDate = $createdAt->addDays(60)->toDateTimeString(); // Add 2 days for High priority
                        break;
                    case '4':
                        $dueDate = $createdAt->addDays(70)->toDateTimeString(); // Add 2 days for High priority
                        break;    
                    default:
                        $dueDate = $createdAt->toDateString(); // Default to created_at if priority is not recognized
                        break;        
            }

            // Update work order
            WorkOrder::where('id', $original_workOrder_id)
                ->update([
                    'priority'      => $priority,
                    'due_date'      => $dueDate,
                    'updated_at'    => $current_UTC,
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
     * Delete billboard
     */
    public function delete(Request $request)
    {   
        $user = Auth::user();
        
        // // Get user roles
        $role = $user->roles->pluck('name')[0];
        $userID = $this->user->id;

        $id = $request->id;

        logger('delete: ' . $id);

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Update client company
            Billboard::where('id', $id)->delete();

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
}