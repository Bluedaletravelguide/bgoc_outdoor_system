<?php

namespace App\Http\Controllers\ServiceRequests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestCategory;
use App\Models\ServiceRequestSubCategory;
use App\Models\User;
use App\Models\Client;
use App\Models\WorkOrder;
use App\Models\WorkOrderHistory;
use App\Models\NotificationHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\PushNotificationController;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Home\HomeController;
//

// use Notification;
// use App\Notifications\SendEmailNotification;

class ServiceRequestController extends Controller
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
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get user roles
        $role = $user->roles->pluck('name')->first();
        $userID = $user->id;

        logger('role: ' . $role);
        
        // Add serviceRequest role check
        if (!$user || !$user->can('service_request.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any service request!');
        }

        $companyId = null;

        if ($role === 'client_user') {
            $client = Client::where('user_id', $userID)->first();
            if ($client) {
                $companyId = $client->company_id;
            }
        }

        $serviceRequest = ServiceRequest::all();
        $mainCategory   = ServiceRequestCategory::all();
        $subCategory    = ServiceRequestSubCategory::all();
        $projects       = $role === 'client_user'
        ? Project::where('client_company_id', $companyId)->get()
        : Project::all(); // Fetch all projects for non-client users

        return view('serviceRequests.index', compact('projects', 'serviceRequest', 'mainCategory', 'subCategory'));
    }


    /*
    * Service Sub Category list based on the Main Category
    **/
    public function getSubcategories($sr_category_id)
    {
        $subcategories = ServiceRequestSubCategory::where('sr_category_id', $sr_category_id)->get();

        return response()->json($subcategories);
    }

    /*
    * Service Category Controller
    **/
    public function serviceCategory()
    {
        if (is_null($this->user) || !$this->user->can('role.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any service request !');
        }
    
        return view('serviceRequests.category');
    }

    public function serviceCategoryList(Request $request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $data = ServiceRequestSubCategory::leftJoin('sr_category', 'sr_sub_category.sr_category_id', '=', 'sr_category.id')
            ->select('sr_sub_category.sr_category_id', 'sr_category.name as category_name', 'sr_sub_category.name as sub_category_name')
            ->groupBy('sr_sub_category.sr_category_id', 'sr_category.name', 'sr_sub_category.name')
            ->get();

        // Organize the data into an array grouped by sr_category
        $groupedData = $data->groupBy('category_name')->map(function ($items) {
            return $items->pluck('sub_category_name')->toArray();
        });

        // Get a portion of the grouped data based on pagination parameters
        $slicedData = $groupedData->slice($start, $limit);

        $finalData = array();
        $totalData = count($groupedData);
        $totalFiltered = count($groupedData);

        foreach ($slicedData as $categoryName => $subCategories) {
            $originalData = $data->firstWhere('category_name', $categoryName); // Fetch the original data
            $nestedData = array(
                'service_category_name' => $categoryName,
                'sub_categories' => $subCategories,
                'id' => optional($originalData)->sr_category_id, // Use optional() to avoid calling a member function on null
            );
            $finalData[] = $nestedData;
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $finalData,
        );

        echo json_encode($json_data);
    }

    public function serviceRequestList(Request $request)
    {
        $user = Auth::user();
        
        // Get user roles
        $role = $user->roles->pluck('name')[0];
        $userID = $this->user->id;
        
        $columns = array(
            0 => 'service_request_no',
            1 => 'description',
            2 => 'location',
            3 => 'status',
            4 => 'remarks_by_client',
            5 => 'remarks_by_teamleader',
            6 => 'raise_by',
            7 => 'sr_sub_category_id',
            8 => 'sr_category_id',
            9 => 'project_id',
            10 => 'created_at',

        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderColumnName = $columns[$orderColumnIndex] ?? $columns[0];
        $orderDirection = $request->input('order.0.dir', 'desc');
        $service_request_status = $request->service_request_status;
        

        $query = ServiceRequest::leftJoin('sr_category', 'service_request.sr_category_id', '=', 'sr_category.id')
            ->leftJoin('sr_sub_category', 'service_request.sr_sub_category_id', '=', 'sr_sub_category.id')
            ->leftJoin('users', 'service_request.raise_by', "=", 'users.id')
            ->leftJoin('projects', 'service_request.project_id', '=', 'projects.id' )
            ->leftJoin('work_order', 'service_request.work_order_id', '=', 'work_order.id' )
            ->select('service_request.id', 'service_request.service_request_no', 'service_request.description', 'service_request.location', 
            'service_request.remarks_by_client', 'service_request.remarks_by_teamleader', 'service_request.status',
            'sr_category.name as category_name', 'sr_sub_category.name as sub_category_name', 'users.username as user_raise', 
            'projects.project_prefix as project_name', 'service_request.created_at', 'work_order.id as WO_detail')
            ->orderBy($orderColumnName, $orderDirection);

        if (!in_array($role, ['superadmin', 'team_leader'])){
            $query->where('raise_by', $userID);
        }

        if ($service_request_status == "NEW") {
            $query->where('service_request.status', 'NEW');
        } elseif ($service_request_status == "ACCEPTED"){
            $query->where('service_request.status', 'ACCEPTED');
        } elseif ($service_request_status == "CLOSED"){
            $query->where('service_request.status', 'CLOSED');
        } elseif ($service_request_status == "REJECTED"){
            $query->where('service_request.status', 'REJECTED');
        };

        // Get total records count
        $totalData = $query->count();

        $searchValue = trim(strtolower($request->input('search.value')));

        if (!empty($searchValue)) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('service_request.description', 'LIKE', "%{$searchValue}%")
                ->orWhere('service_request.remarks_by_client', 'LIKE', "%{$searchValue}%")
                ->orWhere('service_request.service_request_no', 'LIKE', "%{$searchValue}%")
                ->orWhere('service_request.remarks_by_teamleader', 'LIKE', "%{$searchValue}%");
            });
        }

        // Get total filtered records count
        $totalFiltered = $query->count();

        // Apply pagination
        $filteredData = $query->skip($start)->take($limit)->get();

        $data = array();

        foreach ($filteredData as $d) {
            $nestedData = array(
                'service_request_no' => $d->service_request_no,
                'description' => $d->description,
                'location' => $d->location,
                'client_remark' => $d->remarks_by_client,
                'teamleader_remark' => $d->remarks_by_teamleader,
                'category_name' => $d->category_name,
                'sub_category_name' => $d->sub_category_name,
                'user_raise' => $d->user_raise,
                'project_name'=> $d->project_name,
                'status' => $d->status,
                'created_at' => Carbon::parse($d->created_at)->format('Y-m-d H:i:s'),
                'WO_detail'=> $d->WO_detail,
                'id' => $d->id,
                'action'    => $d->id,
            );
            $data[] = $nestedData;
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );

        echo json_encode($json_data);
    }

    /**
     * Store a newly created resource in storage for category
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function serviceCategoryStore(Request $request)
    {
        // TODO: need to create a service category role to further break down the permissions
        if (is_null($this->user) || !$this->user->can('role.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any category !');
        }

        // Validation Data
        $request->validate([
            'category_name' => 'required|string',
            'sub_categories' => 'required|array',
            'sub_categories.*' => 'string',
        ]);

        // Process Data for category and first or create the category wit the $request->category_name
        /**
         * This might need to be reworked for further testing.
         */
        $category = ServiceRequestCategory::firstOrCreate(['name' => $request->category_name]);

        $category_id = $category->id;

        // Store the sub-categories based on the $category_id which is from the created category above.
        foreach ($request->input('sub_categories') as $subCategoryName) {
            ServiceRequestSubCategory::create([
                'name' => $subCategoryName,
                'sr_category_id' => $category_id,
            ]);
        }
        return back();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('role.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any role !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:roles'
        ], [
            'name.required' => 'Please give a role name'
        ]);

        dd($request);
    }

    /**
     * Update the specified resource in storage for service category and sub-category
     */
    public function serviceCategoryUpdate(Request $request)
    {
        // TODO: need to create a service category role to further break down the permissions
        if (is_null($this->user) || !$this->user->can('role.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any category !');
        }

        // Validation Data
        $request->validate([
            'categoryName' => 'required|string',
            'subCategories' => 'required|array',
            'subCategories.*' => 'string',
        ]);

        $categoryName   = $request->categoryName;
        $subCategories  = $request->subCategories;
        $categoryOriginalId    = $request->categoryOriginalId;

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();
            
            // Update category
            ServiceRequestCategory::where('id', $categoryOriginalId)
                ->update([
                    'name' => $categoryName,
                ]);

            // Update subcategories
            ServiceRequestSubCategory::where('sr_category_id', $categoryOriginalId)->delete();

            foreach ($subCategories as $subCategory) {
                ServiceRequestSubCategory::firstOrCreate([
                    'sr_category_id' => $categoryOriginalId,
                    'name' => $subCategory,
                ]);
            }
    
            // Ensure all queries successfully executed, commit the db changes
            DB::commit();
    
            return response()->json([
                "success" => "success",
            ], 200);
        }catch (\Exception $e) {
            // If any queries fail, undo all changes
            DB::rollback();
    
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function serviceCategoryDestroy(Request $request)
    {
        // Get the current UTC time
        $current_UTC = Carbon::now('UTC');

        $delete_category_id = $request->delete_category_id;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'delete_category_id' => [
                    'required',
                    'integer',
                    'exists:sr_category,id',
                ],
            ],
            [
                'delete_category_id.exists' => 'The category cannot be found.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Update stus to 0 as deleted (soft delete)
            ServiceRequestSubCategory::where('sr_category_id', $delete_category_id)->delete();
            ServiceRequestCategory::where('id', $delete_category_id)->delete();

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


    public function redirectNewTab(Request $request)
    {
        $open_WO_DetailId = WorkOrder::find($request->id);

        return view('workOrderProfile.index', compact('open_WO_DetailId'));
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

        $project = $request->project;
        $description = $request->description;
        $remarks = $request->remarks;
        $priority = $request->priority;;
        $category = $request->category;
        $subcategory = $request->subcategory;

        // Get the current UTC time
        $current_UTC = Carbon::now('UTC');

        try {
            //Create a new service request
            $serviceRequest = ServiceRequest::create([
                'description'           => $description,
                'status'                => 'NEW',
                'remarks_by_client'     => $remarks,
                'sr_category_id'        => $category,
                'sr_sub_category_id'    => $subcategory,
                'raise_by'              => $userID,
                'project_id'            => $project,
            ]);

            // Generate the service request no & work order no based on prefixes and count
            $getPrefixNo = $serviceRequest->generatePrefixNo();

            // Generate the service request number based on prefixes and count
            $serviceRequest->service_request_no = $getPrefixNo[0];
            $serviceRequest->save();

            // Validate the input
            $validator = Validator::make($request->all(), [
                'priority' => 'required|in:1,2,3,4', // Priority must be one of the three values
                ]);
        
                if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
                }
        
                // Retrieve the selected priority
                $priority = $request->priority;
        
                // Get the created_at timestamp
            $createdAt = Carbon::parse($serviceRequest->created_at); // Using created_at of service request
        
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
                    $dueDate = $createdAt->toDateTimeString(); // Default to created_at if priority is not recognized
                    break;
            }

            //Create a new work order
            $data = [
                'work_order_no'         => $getPrefixNo[1],
                'type'                  => 'Manual',
                'status'                => 'NEW',
                'priority'              => $priority,
                'due_date'              => $dueDate,
                'service_request_id'    => $serviceRequest->id,
                'status_changed_by'     => $serviceRequest->raise_by,
            ];

            // Log the data array before saving
            $workOrder = WorkOrder::create($data);

            // Generate the service request number based on prefixes and count
            $workOrder->work_order_no = $getPrefixNo[1];
            $workOrder->save();

            // Generate the service request number based on prefixes and count
            $serviceRequest->work_order_id = $workOrder->id;
            $serviceRequest->save();

            //Create new work order history
            WorkOrderHistory::create([
                'status'            => $workOrder->status,
                'status_changed_by' => $workOrder->status_changed_by,
                'work_order_id'     => $workOrder->id,
            ]);

            $pushNotificationController = new PushNotificationController();
            $pushNotificationController->sendEmailNewSR($serviceRequest, $workOrder);

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
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id                     = $request->id;
        $desc                   = $request->desc;
        $remarks                = $request->client_remark;

        logger('id ' . $id);
        logger('desc ' . $desc);
        logger('remarks ' . $remarks);

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'desc' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'client_remark' => [
                    'required',
                    'string',
                    'max:255',
                ],
            ],
            [
                'desc.required' => 'The "Description" field is required.',
                'desc.string' => 'The "Description" must be a string.',
                'desc.max' => 'Description" must not be greater than :max characters.',

                'client_remark.required' => 'The "Client Remarks" field is required.',
                'client_remark.string' => 'The "Client Remarks" must be a string.',
                'client_remark.max' => 'The "Client Remarks" field must not be greater than :max characters.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Update client company
            ServiceRequest::where('id', $id)
                ->update([
                    'description'          => $desc,
                    'remarks_by_client'    => $remarks,
                ]);

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

    /**
     * Reject service request and work order.
     */
    public function reject(Request $request)
    {   
        $user = Auth::user();
        
        // // Get user roles
        $role = $user->roles->pluck('name')[0];
        $userID = $this->user->id;

        $id = $request->id;
        $reject_remark = $request->reject_remark;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'reject_remark' => [
                    'required',
                    'string',
                    'max:255',
                ],
            ],
            [
                'reject_remark.required' => 'The "Reject Remarks" field is required.',
                'reject_remark.string' => 'The "Reject Remarks" must be a string.',
                'reject_remark.max' => 'The "Reject Remarks" field must not be greater than :max characters.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Update client company
            ServiceRequest::where('id', $id)
                ->update([
                    'status'                    => 'REJECTED',
                    'remarks_by_teamleader'      => $reject_remark,
                ]);

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

    /**
     * Delete service request and work order.
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

            // Update client company
            ServiceRequest::where('id', $id)->delete();

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
