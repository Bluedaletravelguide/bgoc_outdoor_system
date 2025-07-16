<?php

namespace App\Http\Controllers\Api\Clients;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Contract;
use App\Models\ClientCompany;
use App\Models\WorkOrder;
use App\Models\WorkOrderHistory;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestPhoto;
use Illuminate\Support\Facades\DB as Database;
use App\Models\ServiceRequestCategory;
use App\Models\ServiceRequestSubCategory;
use App\Models\NotificationHistory;
use App\Models\ServiceRequestPhoto as SRPhoto;
use Carbon\Carbon;
use App\Http\Controllers\PushNotificationController;

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
            $this->user = Auth::guard('api')->user();
            return $next($request);
        });

        $this->middleware('permission:service_request.view', ['only' => ['serviceRequestInProgress', 'serviceRequestCompleted']]);
    }


    public function index(Request $request)
    {
        $srPending = ServiceRequest::where('status', ['NEW'])
        ->where('raise_by', $this->user->id)
        ->count();

        $srInProgress = ServiceRequest::whereIn('status', ['ACCEPTED'])
        ->where('raise_by', $this->user->id)
        ->count();

        $srRejected = ServiceRequest::whereIn('status', ['REJECTED'])
        ->where('raise_by', $this->user->id)
        ->count();

        $srCompleted = ServiceRequest::whereIn('status', ['CLOSED'])
        ->where('raise_by', $this->user->id)
        ->count();

        return response()->json([
            'pending' => $srPending,
            'inProgress' => $srInProgress,
            'rejected' => $srRejected,
            'completed' => $srCompleted,
        ]);
    }


    /**
     * Show the in-progress service request list.
     */
    public function serviceRequestInProgress(Request $request)
    {
        $serviceRequests = ServiceRequest::selectRaw('service_request.id, service_request.service_request_no, service_request.location, service_request.status, service_request.created_at, sr_category.name AS sr_category_name, sr_sub_category.name AS sr_sub_category_name')
            ->leftJoin('sr_category', 'sr_category.id', '=', 'service_request.sr_category_id')
            ->leftJoin('sr_sub_category', 'sr_sub_category.id', '=', 'service_request.sr_sub_category_id')
            ->where('raise_by', $this->user->id)
            ->whereNotIn('status', ['REJECTED', 'CLOSED'])
            ->orderBy('id', 'desc')
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
     * Show the completed service request list.
     */
    public function serviceRequestCompleted(Request $request)
    {

        $user = Auth::user();
        
        // Get user roles
        $role = $user->roles->pluck('name')[0];
        $userID = $this->user->id;

        // determine user role
        $isClient = $isClient = $role == "client_user" && $user->status == 1;
        $isSupervisor = in_array($role, ["employee_supervisor", "vendor_supervisor"]) && $user->status == 1;

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
            ->whereNotIn('service_request.status', ['ACCEPTED', 'NEW'])
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
     * Show the completed service request status.
     */
    public function serviceRequestDetail(Request $request, $srId)
    {

        $srNewStatus = ServiceRequest::leftJoin('work_order', 'work_order.id', '=', 'service_request.work_order_id')
            ->leftJoin('work_order_history', 'work_order.id', '=', 'work_order_history.work_order_id')
            ->selectRaw('service_request.id, service_request.created_at as sr_created_at, service_request.status as sr_status, work_order.status as wo_status, work_order_history.status as woh_status, work_order.created_at as wo_created_at, work_order_history.created_at as woh_created_at')
            ->where('raise_by', $this->user->id)
            ->where('service_request.id', '=', $srId)
            ->whereIn('work_order_history.status', ['NEW'])
            ->orderBy('work_order_history.created_at', 'ASC')
            ->limit(1)
            ->get();

        $srInProgressStatus = ServiceRequest::leftJoin('work_order', 'work_order.id', '=', 'service_request.work_order_id')
            ->leftJoin('work_order_history', 'work_order.id', '=', 'work_order_history.work_order_id')
            ->selectRaw('service_request.id, service_request.created_at as sr_created_at, service_request.status as sr_status, work_order.status as wo_status, work_order_history.status as woh_status, work_order.created_at as wo_created_at, work_order_history.created_at as woh_created_at')
            ->where('raise_by', $this->user->id)
            ->where('service_request.id', '=', $srId)
            ->whereIn('work_order_history.status', ['ASSIGNED_SP'])
            ->orderBy('work_order_history.created_at', 'ASC')
            ->limit(1)
            ->get();

        $srCloseStatus = ServiceRequest::leftJoin('work_order', 'work_order.id', '=', 'service_request.work_order_id')
            ->leftJoin('work_order_history', 'work_order.id', '=', 'work_order_history.work_order_id')
            ->selectRaw('service_request.id, service_request.created_at as sr_created_at, service_request.status as sr_status, work_order.status as wo_status, work_order_history.status as woh_status, work_order.created_at as wo_created_at, work_order_history.created_at as woh_created_at')
            ->where('raise_by', $this->user->id)
            ->where('service_request.id', '=', $srId)
            ->whereIn('work_order_history.status', ['VERIFICATION_PASSED'])
            ->orderBy('work_order_history.created_at', 'ASC')
            ->limit(1)
            ->get();

        $srRejectStatus = ServiceRequest::leftJoin('work_order', 'work_order.id', '=', 'service_request.work_order_id')
            ->leftJoin('work_order_history', 'work_order.id', '=', 'work_order_history.work_order_id')
            ->selectRaw('service_request.id, service_request.created_at as sr_created_at, service_request.status as sr_status, work_order.status as wo_status, work_order_history.status as woh_status, work_order.created_at as wo_created_at, work_order_history.created_at as woh_created_at')
            ->where('raise_by', $this->user->id)
            ->where('service_request.id', '=', $srId)
            ->whereIn('work_order_history.status', ['REJECTED'])
            ->orderBy('work_order_history.created_at', 'ASC')
            ->limit(1)
            ->get();

        $srDetail = ServiceRequest::leftJoin('service_request_photos', 'service_request.id', '=', 'service_request_photos.service_request_id')
            ->leftJoin('sr_category', 'sr_category.id', '=', 'service_request.sr_category_id')
            ->leftJoin('sr_sub_category', 'sr_sub_category.id', '=', 'service_request.sr_sub_category_id')
            ->selectRaw('service_request.id, service_request.created_at as sr_created_at, service_request.status as sr_status, service_request.service_request_no as sr_no, description, location, remarks_by_occ, 
            sr_category.name as sr_category_name, sr_sub_category.name as sr_sub_category_name, service_request_photos.id, service_request_photos.url, service_request_photos.service_request_id')
            ->where('raise_by', $this->user->id)
            ->where('service_request.id', '=', $srId)
            ->get();

        $srNewStatus->transform(function ($srNewStat) {
            // Convert to Dubai time
            $dubaiTime = Carbon::parse($srNewStat->woh_created_at)->timezone('Asia/Dubai');

            // Add new formatted date, month, and year fields to the object
            $srNewStat->dubai_created_at = $dubaiTime->format('Y-m-d H:i:s');

            return $srNewStat;
        });


        $srInProgressStatus->transform(function ($srInProgressStat) {
            // Convert to Dubai time
            $dubaiTime = Carbon::parse($srInProgressStat->woh_created_at)->timezone('Asia/Dubai');

            // Add new formatted date, month, and year fields to the object
            $srInProgressStat->dubai_created_at = $dubaiTime->format('Y-m-d H:i:s');
            return $srInProgressStat;
        });

        $srCloseStatus->transform(function ($srCloseStat) {
            // Convert to Dubai time
            $dubaiTime = Carbon::parse($srCloseStat->woh_created_at)->timezone('Asia/Dubai');

            // Add new formatted date, month, and year fields to the object
            $srCloseStat->dubai_created_at = $dubaiTime->format('Y-m-d H:i:s');
            return $srCloseStat;
        });

        $srRejectStatus->transform(function ($srRejectStat) {
            // Convert to Dubai time
            $dubaiTime = Carbon::parse($srRejectStat->woh_created_at)->timezone('Asia/Dubai');

            // Add new formatted date, month, and year fields to the object
            $srRejectStat->dubai_created_at = $dubaiTime->format('Y-m-d H:i:s');
            return $srRejectStat;
        });

        $srDetail->transform(function ($srDetails) {
            // Convert to Dubai time
            $dubaiTime = Carbon::parse($srDetails->sr_created_at)->timezone('Asia/Dubai');

            // Add new formatted date, month, and year fields to the object
            $srDetails->dubai_created_at = $dubaiTime->format('Y-m-d H:i:s');
            return $srDetails;
        });

        return response()->json([
            'newStatusDate' => $srNewStatus,
            'InProgressDate' => $srInProgressStatus,
            'CloseStatusDate' => $srCloseStatus,
            'RejectStatusDate' => $srRejectStatus,
            'DetailDate' => $srDetail,
        ]);
    }

    /**
     * Fetch and display images
     */
    public function fetchImage(Request $request, $srId)
    {

        try{
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // fetch image
            $fetchImage = ServiceRequestPhoto::select('id', 'url', 'service_request_id')
            ->where('service_request_id', '=', $srId)
            ->get();

            $imageData = [];

            foreach ($fetchImage as $image) {

                $imageUrl = asset('storage/' . $image->url);
                $imageData[] = [
                    'id' => $image->id,
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

    /**
     * Get information before creating the service request.
     */
    public function serviceRequestPreCreate(Request $reqeust)
    {   
        //Get the main and sub category
        // $allCatergories = ServiceRequestCategory::select('sr_category.id as category_id', 'sr_category.name as category_name', 'sr_sub_category.id as sub_category_id', 'sr_sub_category.name as sub_category_name')
        //     ->leftJoin('sr_sub_category', 'sr_category.id', '=', 'sr_sub_category.sr_category_id')
        //     ->orderBy('sr_category.id', 'asc');

        $mainCategory   = ServiceRequestCategory::all();
        $subcategory    = ServiceRequestSubCategory::all();

        return response()->json([
            'mainCategory' => $mainCategory,
            'subCategory'  => $subcategory,
        ], 200);
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

        // determine user role
        $isSupervisor = in_array($role, ["employee_supervisor", "vendor_supervisor"]) && $user->status == 1;

        //Input from client apps
        $pictureList        = $request->input('pictureList');
        // $serviceRequestNo   = $request->input('serviceRequestNo');
        $location           = $request->input('location');
        $description        = $request->input('description');
        $remarks            = $request->input('remarks');
        $category           = $request->input('category');
        $subcategory        = $request->input('subcategory');

        // Get the current UTC time
        $current_UTC = Carbon::now('UTC');

        //Retrieve the contract id
        $contract = User::select('users.id as user_id','users.name', 'contracts.*')
            // ->with('client_company')
            ->leftJoin('clients', 'users.id', '=', 'clients.user_id')
            ->leftJoin('client_company', 'clients.company_id', '=', 'client_company.id')
            ->leftJoin('contracts', 'client_company.id', '=', 'contracts.client_company_id')
            ->where('users.id', $userID)
            ->where('contracts.to_date', '>=', $current_UTC->toDateString())
            ->whereNot('contracts.type', 'closed')
            ->first();

        if(!is_null($contract)){
            //
        }

        // $categoryId = DB::table('sr_category')
        //     ->where('name', 'LIKE', "%{$category}%")
        //     ->first();
        
        // $subcategoryId = DB::table('sr_sub_category')
        //     ->where('name', 'LIKE', "%{$subcategory}%")
        //     ->first();

        //Create a new service request
        $serviceRequest = ServiceRequest::create([
            'description'           => $description,
            'location'              => $location ,
            'status'                => 'NEW',
            'remarks_by_client'     => $remarks,
            'sr_category_id'        => $category,
            'sr_sub_category_id'    => $subcategory,
            'raise_by'              => $contract->user_id,
            'contract_id'           => $contract->id,
        ]);

        // Generate the service request no & work order no based on prefixes and count
        $getPrefixNo = $serviceRequest->generatePrefixNo();

        // Generate the service request number based on prefixes and count
        $serviceRequest->service_request_no = $getPrefixNo[0];
        $serviceRequest->save();

        // info($serviceRequest);
        // info($serviceRequest->id);

        //Create service request photo
        $pictureArray = explode("/%% %%/", $pictureList);
        // print_r($pictureArray);

        foreach($pictureArray as $d){
            if($d !== ""){
                $decodedPicture     = base64_decode($d);
                $pictureFilename    = 'photo_'. uniqid() .'.jpg';
    
                Storage::disk('public')->put($pictureFilename, $decodedPicture);
                $picturePath =  Storage::disk('public')->path($pictureFilename);
        
                $serviceRequestPhotos = ServiceRequestPhoto::create([
                    'url'                   => $picturePath,
                    'service_request_id'    => $serviceRequest->id,
                ]);
            }
        }

        //Create a new work order
        $data = [
            'work_order_no'         => $getPrefixNo[1],
            'type'                  => 'Manual',
            'status'                => 'NEW',
            'priority'              => 'Low',
            'service_request_id'    => $serviceRequest->id,
            'status_changed_by'     => $serviceRequest->raise_by,
            'contract_id'           => $serviceRequest->contract_id,
        ];

        // Check if the user is a supervisor
        if ($isSupervisor) {
            $data['assign_to_supervisor'] = $userID;
            $data['status'] = 'ASSIGNED_SP';
        }

        $workOrder = WorkOrder::create($data);

        // Generate the service request number based on prefixes and count
        // $workOrder->work_order_no = $getPrefixNo[1];
        // $workOrder->save();

        //Create new work order history
        WorkOrderHistory::create([
            'status'            => $workOrder->status,
            'status_changed_by' => $workOrder->status_changed_by,
            'work_order_id'     => $workOrder->id,
        ]);

        //Update the service request status to ACCEPTED
        ServiceRequest::where('id', $serviceRequest->id)
            ->update([
                'status'        => 'ACCEPTED',
                'work_order_id' => $workOrder->id,
            ]);

        // Ensure all queries successfully executed, commit the db changes
        DB::commit();

        /////////////////////////// send notification ////////////////////////////////
        $srNo = ServiceRequest::where('service_request.id', $serviceRequest->id)
            ->leftJoin('sr_sub_category', 'sr_sub_category.id', '=', 'service_request.sr_sub_category_id')
            ->select('service_request.service_request_no', 'service_request.raise_by', 'sr_sub_category.name as subcat_name')
            ->get();

        $title = 'Your service request has been accepted';
        $desc = $srNo[0]->subcat_name . ' has been accepted.';
        $user_id = $srNo[0]->raise_by;

        // Combine title and description
        $combinedMessage = $title . ': ' . $desc;

        // Call the notification controller
        $result = (new PushNotificationController)->sendPushNotification(['title' => $title, 'message' => $desc, 'user_id' => $user_id]);
        /////////////////////////// send notification ////////////////////////////////

        //Write the notification message into DB
        NotificationHistory::create([
            'notification_content'  => $combinedMessage,
            'user_id'               => $serviceRequest->raise_by,
            'status'                => 'NEW',
        ]);

        return response()->json([
            'success'   => 'success',
        ], 200);
    }
}
