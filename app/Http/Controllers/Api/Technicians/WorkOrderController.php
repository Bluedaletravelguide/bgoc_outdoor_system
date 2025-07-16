<?php

namespace App\Http\Controllers\Api\Technicians;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\WorkOrder;
use App\Models\WorkOrderHistory;
use App\Models\WorkOrderObservations;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestPhoto;
use App\Models\WorkOrderObservationsPhoto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\PushNotificationController;

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
            $this->user = Auth::guard('api')->user();
            return $next($request);
        });

        $this->middleware('permission:work_order.view', ['only' => ['workOrderInProgress', 'workOrderCompleted']]);
    }

    /**
     * Show the counts of pending/in-progress work order.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get user roles
        $role = $user->roles->pluck('name')[0];
        $userID = $this->user->id;

        // determine user role
        $isTechnician = in_array($role, ["employee_technician", "vendor_technician"]) && $user->status == 1;
        $isSupervisor = in_array($role, ["employee_supervisor", "vendor_supervisor"]) && $user->status == 1;        
        
        //query for pending work order count
        $woPending = WorkOrder::where('status', ['ASSIGNED_TECHNICIAN'])
        ->when($isTechnician, function ($query) use ($userID) {
            return $query->where('assign_to_technician', $userID);
        })
        ->when($isSupervisor, function ($query) use ($userID) {
            return $query->where(function ($query) use ($userID) {
                $query->where('assign_to_supervisor', $userID)
                      ->orWhere(function ($query) use ($userID) {
                          $query->whereNull('assign_to_supervisor')
                                ->where('status_changed_by', $userID);
                      });
            });
        })
        ->count();

        // query for in progress work order count
        $woInProgress = WorkOrder::whereIn('status', ['ACCEPTED_TECHNICIAN', 'ASSIGNED_SP', 'STARTED'])

        ->when($isTechnician, function ($query) use ($userID) {
            return $query->where('assign_to_technician', $userID);
        })
        ->when($isSupervisor, function ($query) use ($userID) {
            return $query->where(function ($query) use ($userID) {
                $query->where('assign_to_supervisor', $userID)
                      ->orWhere(function ($query) use ($userID) {
                          $query->whereNull('assign_to_supervisor')
                                ->where('status_changed_by', $userID);
                      });
            });
        })
        ->count();

        // query for completed work order count
        $woCompleted = WorkOrder::whereIn('status', ['VERIFICATION_PASSED'])
        ->when($isSupervisor, function ($query) use ($userID) {
            return $query->where(function ($query) use ($userID) {
                $query->where('assign_to_supervisor', $userID)
                      ->orWhere(function ($query) use ($userID) {
                          $query->whereNull('assign_to_supervisor')
                                ->where('status_changed_by', $userID);
                      });
            });
        })
        ->count();

        // query for rejected work order count
        $woRejected = WorkOrder::whereIn('status', ['REJECTED'])
        ->when($isSupervisor, function ($query) use ($userID) {
            return $query->where(function ($query) use ($userID) {
                $query->where('assign_to_supervisor', $userID)
                      ->orWhere(function ($query) use ($userID) {
                          $query->whereNull('assign_to_supervisor')
                                ->where('status_changed_by', $userID);
                      });
            });
        })
        ->count();

        return response()->json([
            'pending' => $woPending,
            'inProgress' => $woInProgress,
            'completed' => $woCompleted,
            'rejected' => $woRejected,
        ]);
    }


    /**
     * Show the in-progress work order list.
     */
    public function workOrderInProgress(Request $request)
    {
        
        $user = Auth::user();

        // Get user roles
        $role = $user->roles->pluck('name')[0];

        $userID = $this->user->id;

        // determine user role
        $isTechnician = in_array($role, ["employee_technician", "vendor_technician"]) && $user->status == 1;
        $isSupervisor = in_array($role, ["employee_supervisor", "vendor_supervisor"]) && $user->status == 1;

        $workOrders = WorkOrder::selectRaw('work_order.id, work_order.work_order_no, work_order.type, work_order.status, work_order.service_request_id, service_request.location, work_order.assign_to_technician, sr_category.name AS sr_category_name, sr_sub_category.name AS sr_sub_category_name, work_order.created_at')
            ->leftJoin('service_request', 'service_request.id', '=', 'work_order.service_request_id')
            ->leftJoin('sr_category', 'sr_category.id', '=', 'service_request.sr_category_id')
            ->leftJoin('sr_sub_category', 'sr_sub_category.id', '=', 'service_request.sr_sub_category_id')
            ->when($isTechnician, function ($query) use ($userID) {
                return $query->where('assign_to_technician', $userID);
            })
            ->when($isSupervisor, function ($query) use ($userID) {
                return $query->where('assign_to_supervisor', $userID);
            })
            ->whereIn('work_order.status', ['ASSIGNED_TECHNICIAN', 'ACCEPTED_TECHNICIAN', 'ASSIGNED_SP', 'STARTED'])
            ->orderBy('work_order.id', 'desc')
            ->paginate(5);

        $workOrders->transform(function ($workOrder) {
            // Convert to Dubai time
            $dubaiTime = Carbon::parse($workOrder->created_at)->timezone('Asia/Dubai');

            // Add new formatted date, month, and year fields to the object
            $workOrder->dubai_created_at = $dubaiTime->toDateTimeString();
            $workOrder->date = $dubaiTime->format('d');
            $workOrder->month = $dubaiTime->format('M');
            $workOrder->year = $dubaiTime->format('Y');

            return $workOrder;
        });

        return response()->json([
            'workOrder' => $workOrders,
        ]);
    }

    /**
     * Show the in-progress work order list.
     */
    public function workOrderCompleted(Request $request)
    {
        
        $user = Auth::user();

        // Get user roles
        $role = $user->roles->pluck('name')[0];

        $userID = $this->user->id;

        // determine user role
        $isTechnician = in_array($role, ["employee_technician", "vendor_technician"]) && $user->status == 1;
        $isSupervisor = in_array($role, ["employee_supervisor", "vendor_supervisor"]) && $user->status == 1;
        $isClient = $isClient = $role == "client_user" && $user->status == 1;

        $serviceRequests = ServiceRequest::selectRaw('service_request.id, service_request.service_request_no, service_request.location, service_request.status, service_request.created_at, sr_category.name AS sr_category_name, sr_sub_category.name AS sr_sub_category_name')
            ->leftJoin('sr_category', 'sr_category.id', '=', 'service_request.sr_category_id')
            ->leftJoin('sr_sub_category', 'sr_sub_category.id', '=', 'service_request.sr_sub_category_id')
            ->leftJoin('work_order', 'work_order.id', '=', 'service_request.work_order_id')
            ->when($isClient, function ($query) use ($userID) {
                return $query->where('raise_by', $userID);
            })
            ->when($isSupervisor, function ($query) use ($userID) {
                return $query->where('work_order.assign_to_supervisor', $userID);
                // ->whereIn('work_order.status', ['COMPLETED', 'REJECTED']);
            })
            ->whereIn('service_request.status', ['CLOSED', 'REJECTED'])
            ->whereNotIn('work_order.status', ['ASSIGNED_SP', 'ASSIGNED_TECHNICIAN', 'ACCEPTED_TECHNICIAN', 'STARTED'])
            ->orderBy('service_request.id', 'desc')
            ->paginate(5);

        $serviceRequests->transform(function ($serviceRequest) {
            // Convert to Dubai time
            $dubaiTime = Carbon::parse($serviceRequest->created_at)->timezone('Asia/Dubai');

            // Add new formatted date, month, and year fields to the object
            $serviceRequest->dubai_created_at = $dubaiTime->toDateTimeString();
            $serviceRequest->date = $dubaiTime->format('d');
            $serviceRequest->month = $dubaiTime->format('F');
            $serviceRequest->year = $dubaiTime->format('Y');

            return $serviceRequest;
        });

        return response()->json([
            'serviceRequest' => $serviceRequests,
        ]);
    }

    /**
     * Show the in-progress work order detail.
     */
    public function woInProgressDetail(Request $request, $woId)
    {
        // select work order inprogress details
        $woInProgressDetails = WorkOrder::selectRaw('work_order.id, work_order.work_order_no, service_request.description, work_order.status, service_request.location, service_request.remarks_by_occ, sr_category.name AS sr_category_name, sr_sub_category.name AS sr_sub_category_name, work_order.created_at')
            ->leftJoin('service_request', 'service_request.id', '=', 'work_order.service_request_id')
            ->leftJoin('sr_category', 'sr_category.id', '=', 'service_request.sr_category_id')
            ->leftJoin('sr_sub_category', 'sr_sub_category.id', '=', 'service_request.sr_sub_category_id')
            ->where('work_order.id', '=', $woId)
            ->get();

        $woInProgressDetails->transform(function ($woInProgressDetail) {
            // Convert to Dubai time
            $dubaiTime = Carbon::parse($woInProgressDetail->created_at)->timezone('Asia/Dubai');

            // Add new formatted date, month, and year fields to the object
            $woInProgressDetail->created_dt = $dubaiTime->format('Y-m-d H:i:s');

            return $woInProgressDetail;
        });

        return response()->json([
            'data' => $woInProgressDetails,
        ]);
    }

    /**
     * Accept job function.
     */
    public function acceptJob(Request $request)
    {
        $userID = $this->user->id;
        
        if ($request->status == "1"){
            $status = "ACCEPTED_TECHNICIAN";
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // get work order
            $history = WorkOrder::select('id', 'status_changed_by', 'assign_to_supervisor', 'assign_to_technician')
            ->where('id', $request->woId)
            ->get();

            // Update work order status
            $updateWorkOrder = WorkOrder::where('id', $request->woId)
            ->update([
                'status_changed_by'         => $userID,
                'status'                    => $status,
            ]);

            // Insert into work order history
            $woHistory = WorkOrderHistory::create([
                'status'                    => $status,
                'status_changed_by'         => $userID,
                'assign_to_supervisor'      => $history[0]->assign_to_supervisor,
                'assign_to_technician'      => $history[0]->assign_to_technician,
                'work_order_id'             => $request->woId,
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
     * Reject job function.
     */
    public function rejectJob(Request $request)
    {
        $userID = $this->user->id;

        if ($request->status == "2"){
            $status = "REJECTED_DIFFERENT_SKILL";
        } elseif ($request->status == "3"){
            $status = "REJECTED_MATERIAL";
        } elseif ($request->status == "4"){
            $status = "REJECTED_ACCESS";
        }
        
        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // get work order
            $history = WorkOrder::select('id', 'status_changed_by', 'assign_to_supervisor', 'assign_to_technician')
            ->where('id', $request->woId)
            ->get();

            // Update work order status
            $updateWorkOrder = WorkOrder::where('id', $request->woId)
            ->update([
                'status_changed_by'         => $userID,
                'status'                    => $status,
            ]);

            // Insert into work order history
            $woHistory = WorkOrderHistory::create([
                'status'                    => $status,
                'status_changed_by'         => $userID,
                'assign_to_supervisor'      => $history[0]->assign_to_supervisor,
                'assign_to_technician'      => $history[0]->assign_to_technician,
                'work_order_id'             => $request->woId,
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
     * Store images 
     */
    public function storeImage(Request $request)
    {

        $user = Auth::user();

        // Get user roles
        $role = $user->roles->pluck('name')[0];

        $userID = $this->user->id;
        
        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'images' => [
                    'required',
                ],
                'remarks' => [
                    'required',
                ],
            ],
            [
                'images.required' => 'The before work observation photo is required.',
                'remarks.required' => 'The before work observsation remarks is required.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try{
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // get work order history
            $woHistoryId = WorkOrderHistory::select('id', 'status_changed_by', 'assign_to_supervisor', 'assign_to_technician')
            ->where('work_order_id', $request->woId)
            ->where('status', $request->initStatus)
            ->get();

            // get work order
            $workOrder = WorkOrder::select('service_request_id')
            ->where('id', $request->woId)
            ->get();

            // Insert into work order observation
            $woObservation = WorkOrderObservations::create([
                'remarks'                   => $request->remarks,
                'type'                      => $request->type,
                'work_order_id'             =>  $request->woId,
                'work_order_history_id'     => $woHistoryId[0]->id,
            ]);

            // get the ID of the newly inserted record
            $woObservationId = $woObservation->id;

            // Insert into work order history
            $woHistory = WorkOrderHistory::create([
                'status'                    => $request->status,
                'status_changed_by'         => $userID,
                'assign_to_supervisor'      => $woHistoryId[0]->assign_to_supervisor,
                'assign_to_technician'      => $woHistoryId[0]->assign_to_technician,
                'work_order_id'             => $request->woId,
            ]);

            // Update work order status
            $updateWorkOrder = WorkOrder::where('id', $request->woId)
            ->update([
                'status' => $request->status,
            ]);


            foreach ($request->file('images') as $index => $imageFile) {
                // Store each uploaded image
                $path = $imageFile->store('images', 'public');
                $imagePaths[] = $path;

                // Insert into work observation photo
                $savePhoto = WorkOrderObservationsPhoto::create([
                    'url'                           => $path,
                    'wo_observations_id'    => $woObservationId,
                ]);
            }

            // Ensure all queries successfully executed, commit the db changes
            DB::commit();

            return response()->json([
                "success"   => "success",
            ], 200);

        } catch (\Exception $e) {
        //     // If any queries fail, undo all changes
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
    /**
     * Fetch and display images
     */
    public function fetchImage(Request $request, $type, $woId)
    {

        try{
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // fetch image
            $fetchImage = WorkOrderObservationsPhoto::select('id', 'url', 'wo_observations_id')
            ->whereIn('wo_observations_id', function ($query) use ($woId, $type) {
                $query->select('id')
                    ->from('work_order_observations')
                    ->where('type', $type)
                    ->where('work_order_id', $woId);
            })
            ->get();

            $imageData = [];

            foreach ($fetchImage as $image) {

                $imageUrl = asset('storage/' . $image->url);
                $imageData[] = [
                    'id' => $image->id,
                    'status' => $image->status,
                    'url' => $imageUrl,
                ];
            }

            // Ensure all queries successfully executed, commit the db changes
            DB::commit();

            return response()->json([
                "success"   => "success",
                'imageData' => $imageData,
            ], 200);

        } catch (\Exception $e) {
            // If any queries fail, undo all changes
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
