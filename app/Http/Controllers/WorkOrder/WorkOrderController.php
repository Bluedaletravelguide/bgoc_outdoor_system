<?php

namespace App\Http\Controllers\WorkOrder;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ClientCompany;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderHistory;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestCategory;
use App\Models\ServiceRequestSubCategory;
use App\Models\NotificationHistory;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PushNotificationController;
use Illuminate\Support\Facades\Log;

class WorkOrderController extends Controller
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
        if (is_null($this->user) || !$this->user->can('work_order.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any project. Contact system admin for access !');
        }
        // $type = Project::distinct()->get(['type']);
        // return view('projects.index', compact('type'));

        $clientcompany = ClientCompany::orderBy('name', 'ASC')->get();
        $projects = Project::all();

        $technicians = User::whereHas('roles', function ($q){
            $q->where('roles.name', 'like', '%technician%');
        })->get();

        $teamleaders = User::whereHas('roles', function ($q){
            $q->where('roles.name', 'like', '%team_leader%');
        })->get();

        // return view('workOrder.index', compact('clientcompany', 'projects', 'supervisors', 'technicians'));
        return view('workOrder.index', compact('clientcompany', 'projects', 'technicians', 'teamleaders'));
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
        $isTechnician = in_array($role, ["employee_technician"]) && $user->status == 1;
        $isAdmin = in_array($role, ["superadmin", "team_leader"]) && $user->status == 1;

        // $supervisor = $request->input('supervisor');
        $technician = $request->input('technician');
        $teamleader = $request->input('teamleader');
        $status     = $request->input('status');

        $columns = array(
            0 => 'work_order_no',
            1 => 'description',
            2 => 'type',
            3 => 'status',
            4 => 'priority',
            5 => 'created_at',
            6 => 'due_date',
            7 => 'teamleader_assigned',
            8 => 'technician_assigned',
            9 => 'id',
        );

        $limit              = $request->input('length');
        $start              = $request->input('start');
        $orderColumnIndex   = $request->input('order.0.column');
        $orderColumnName    = $columns[$orderColumnIndex];
        $orderDirection     = $request->input('order.0.dir');

        $query = WorkOrder::select('work_order.*', 'service_request.description as description', 'team_leader.name as teamleader_name', 'technicians.name as technician_name')
            ->leftJoin('service_request', 'work_order.service_request_id', '=', 'service_request.id')
            ->leftJoin('users as team_leader', 'work_order.assigned_teamleader', '=', 'team_leader.id')
            ->leftJoin('users as technicians', 'work_order.assign_to_technician', '=', 'technicians.id')
            ->orderBy($orderColumnName, $orderDirection);

        // Superadmin permission
        if($isAdmin){
            if($teamleader != 'all' && $teamleader != 'none'){
                $query = $query->where('work_order.assigned_teamleader', $teamleader);
            }elseif($teamleader == 'none'){
                $query = $query->whereNull('work_order.assigned_teamleader');
            }

            if($technician != 'all' && $technician != 'none'){
                $query = $query->where('work_order.assign_to_technician', $technician);
            }elseif($technician == 'none'){
                $query = $query->where('work_order.assign_to_technician', $technician);
            }
        }

        // Technician permission
        if($isTechnician){
            $query = $query->where('work_order.assign_to_technician', $userID);
        }

        if ($status != "all") {
            $query->where('work_order.status', $status);
        }

        if ($technician != "all") {
            $query->where('work_order.assign_to_technician', $technician);
        }

        if ($teamleader != "all") {
            $query->where('work_order.assigned_teamleader', $teamleader);
        }

        // Get total records count
        $totalData = $query->count();

        $searchValue = trim(strtolower($request->input('search.value')));

        if (!empty($searchValue)) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('service_request.description', 'LIKE', "%{$searchValue}%");
            });
        }

        // Get total filtered records count
        $totalFiltered = $query->count();

        // Apply pagination
        $filteredData = $query->skip($start)->take($limit)->get();

        $data = array();

        foreach ($filteredData as $d) {
            $created_at = Carbon::parse($d->created_at)->format('Y-m-d H:i:s');

            $nestedData = array(
                'work_order_no'         => $d->work_order_no,
                'description'           => $d->description,
                'type'                  => $d->type,
                'status'                => $d->status,
                'priority'              => $d->priority,
                'created_at'            => $created_at,
                'due_date'              => $d->due_date ? Carbon::parse($d->due_date)->toDateTimeString() : 'N/A',
                'teamleader_assigned'   => $d->teamleader_name,
                'technician_assigned'   => $d->technician_name,
                'WO_detail'             => $d->id,
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

        echo json_encode($json_data);
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
     * Assign technician and update work order status to ASSIGNED_TECHNICIAN
     */
    private function updateStatus_AssignTechnician($request) 
    {
        //Check the permission to update the status of work order 
        if (!$this->user->hasRole(['superadmin', 'team_leader'])) {
            return response()->json(['error' => 'Sorry !! You are Unauthorized to update status of work order. Contact system admin for access !'], 403);
        };
        
        // Get the current UTC time
        $current_UTC = Carbon::now('UTC');
        
        $work_order_id  = $request->original_workOrder_id;
        $assigned_technician    = $request->assigned_technician;
        $update_status = $request->update_status;
        
        //Validation rules
        $validator = Validator::make(
            $request->all(),
            [
                'original_workOrder_id' => [
                    'required',
                    'string',
                    'max:255',
                    // Rule::exists('work_order', 'id')->where(function ($query) {
                    //     $query->whereIn('status', 'NEW'); // Add your desired statuses here
                    // }),
                ],
                // 'status_updated' => [
                //     'required',
                // ],
                // 'technician_assigned' => [
                //     'required',
                // ],
            ],
            // [
            //     'original_workOrder_id.exists' => 'Supervisor only allow to be assigned in ASSIGNED_SP and any REJECTED phase',
            // ],
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();
            
            // Update work order status and assign work order to selected technician
            ServiceRequest::where('work_order_id', $work_order_id)
                ->update([
                    'status'                => 'ACCEPTED',
                    'updated_at'            => $current_UTC,
            ]);
            
            // Update work order status and assign work order to selected technician
            WorkOrder::where('id', $work_order_id)
                ->update([
                    'assign_to_technician'  => $assigned_technician,
                    'assigned_teamleader'   => $this->user->id,
                    'status'                => $update_status,
                    'updated_at'            => $current_UTC,
            ]);
            
            // Create a new work order history
            $work_order = WorkOrder::where('id', $work_order_id)->first();
        
            WorkOrderHistory::create([
                'status'                => $work_order->status,
                'status_changed_by'     => $work_order->status_changed_by,
                'assigned_teamleader'   => $work_order->assigned_teamleader,
                'assign_to_technician'  => $work_order->assign_to_technician,
                'work_order_id'         => $work_order->id,
                'created_at'            => $work_order->updated_at,
            ]);

            /////////////////////////// send notification ////////////////////////////////
            $technician_id    = $work_order['assign_to_technician'];

            $pushNotificationController = new PushNotificationController();
        
            $pushNotificationController->sendEmailNewWO($technician_id, $work_order_id);
            /////////////////////////// send notification ////////////////////////////////

            //Write the notification message into DB
            // NotificationHistory::create([
            //     'notification_content'  => $combinedMessage,
            //     'user_id'               => $work_order['assign_to_technician'],
            //     'status'                => 'ACCEPTED',
            // ]);

            // Ensure all queries successfully executed, commit the db changes
            DB::commit();

            return response()->json([
                'success'   => 'success',
            ], 200);
        } 
        catch (\Exception $e) {
            // If any queries fail, undo all changes
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Update work order status to VERIFICATION_PASSED/VERIFICATION_FAILED
     */
    private function updateStatus_Completed($request) 
    {
        //Check the permission to update the status of work order 
        if (!$this->user->hasRole(['superadmin', 'team_leader'])) {
            return response()->json(['error' => 'Sorry !! You are Unauthorized to update status of work order. Contact system admin for access !'], 403);
        };
        
        // Get the current UTC time
        $current_UTC = Carbon::now('UTC');
        
        $work_order_id  = $request->original_workOrder_id;
        $update_status = $request->update_status;
        
        //Validation rules
        $validator = Validator::make(
            $request->all(),
            [
                'original_workOrder_id' => [
                    'exists:work_order,id,status,STARTED'
                ],
            ],
            [
                'original_workOrder_id.exists' => 'Work order is only allow to be edited in STARTED phase',
            ],
        );
                
        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
        try {

            $serviceRequest = ServiceRequest::where('work_order_id', $work_order_id)->first();
            
            DB::beginTransaction();
                
            // Update work order
            ServiceRequest::where('work_order_id', $work_order_id)
                ->update([
                    'status'            => 'CLOSED',
                    'updated_at'        => $current_UTC,
            ]);
            
            // Update work order
            WorkOrder::where('id', $work_order_id)
                ->update([
                    'status'            => $update_status,
                    'status_changed_by' => $this->user->id,
                    'updated_at'        => $current_UTC,
            ]);
                    
            // Create a new work order history
            $workOrder = WorkOrder::find($work_order_id);
        
            WorkOrderHistory::create([
                'status'                => $workOrder['status'],
                'status_changed_by'     => $workOrder['status_changed_by'],
                'assigned_teamleader'  => $workOrder['assigned_teamleader'],
                'assign_to_technician'  => $workOrder['assign_to_technician'],
                'work_order_id'         => $workOrder['id'],
                'created_at'            => $workOrder['updated_at'],
            ]);

            /////////////////////////// send notification ////////////////////////////////
            $pushNotificationController = new PushNotificationController();
            $pushNotificationController->sendEmailCompletedSR($serviceRequest, $workOrder);
            /////////////////////////// send notification ////////////////////////////////

            // Ensure all queries successfully executed
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
}