<?php

namespace App\Http\Controllers\WorkOrderProfile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestPhoto;
use App\Models\WorkOrderActivity;
use App\Models\WorkOrderActivityAttachment;
use App\Models\WorkOrderHistory;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WorkOrderProfileController extends Controller
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
     * Show the vendor page.
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('workOrder.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any vendor. Contact system admin for access !');
        }



        $servicerequest = WorkOrder::leftJoin('service_request', 'service_request.id', '=', 'work_order.service_request_id');
        $projects = WorkOrder::leftJoin('projects', 'projects.id', '=', 'work_order.project_id');
        return view('workOrderProfile.index', compact('servicerequest', 'projects'));
    }

    public function redirectNewTab(Request $request)
    {

        $filter = $request->input('filter');
        $id = $request->input('id');
        
        $open_WO_DetailId = WorkOrder::find($request->id)
            ->leftJoin('service_request', 'service_request.id', '=', 'work_order.service_request_id')
            ->leftJoin('projects', 'projects.id', '=', 'work_order.project_id')
            ->leftJoin('sr_category', 'sr_category.id', '=', 'service_request.sr_category_id')
            ->leftJoin('sr_sub_category', 'sr_sub_category.id', '=', 'service_request.sr_sub_category_id')
            ->leftJoin('users', 'users.id', '=', 'service_request.raise_by')
            // ->join('work_order_observations', 'work_order_observations.work_order_id', '=', 'work_order.id')
            ->select(
                'work_order.id',
                'service_request.id as service_request_id',
                'projects.id as project_id',
                'work_order.work_order_no',
                'work_order.type',
                'work_order.status',
                'work_order.priority',
                'sr_category.name as sr_category_name',
                'sr_sub_category.name as sr_sub_category_name',
                'users.name as raise_by',
                'service_request.service_request_no as service_request_no',
                'service_request.description as service_request_description',
                'service_request.location as service_request_location',
                'service_request.status as service_request_status',
                'service_request.created_at as created_dt',
                'projects.project_prefix as project_prefix',
                // 'work_order_observations.id as wo_observations_id'
            )
            ->where('work_order.id', '=', $request->id)
            ->first();

            // Convert to Dubai time
            $dubaiTime = Carbon::parse($open_WO_DetailId->created_dt);

            // Add new formatted date, month, and year fields to the object
            $open_WO_DetailId->created_dt = $dubaiTime->format('F j, Y \a\t g:i A');

        if ($open_WO_DetailId !== null) {

            $woActivities = WorkOrderActivity::select(
                'work_order_activity.id as comment_id',
                'comments',
                'comment_by',
                'work_order_activity.created_at as created_at',
                'name',
            )
            ->leftJoin('users', 'users.id', 'work_order_activity.comment_by')
            ->where('work_order_id', '=', $request->id);

            if($filter){
                if ($filter == 'new') {
                    $woActivities->orderBy('created_at', 'desc');
                } elseif ($filter == 'old'){
                    $woActivities->orderBy('created_at', 'asc');
                }
            }
            // ->get();

            $woActivities = $woActivities->get();

            $woActivities->transform(function ($woActivity) {
                // Convert to Dubai time
                $created_dt = Carbon::parse($woActivity->created_at);
    
                // Add new formatted date, month, and year fields to the object
                $woActivity->created_dt = $created_dt->format('F j, Y \a\t g:i A');

                // Fetch related attachments
                $attachments = WorkOrderActivityAttachment::select('id', 'url')
                ->where('wo_activity_id', '=', $woActivity->comment_id)
                ->get();

                // Add attachments to the activity
                $woActivity->attachments = $attachments;
    
                return $woActivity;
            });

            // $gg = $woActivities->get();

            $WoOrHistory = WorkOrderHistory::select(
                'work_order_history.id',
                'work_order_history.status',
                'work_order_history.status_changed_by',
                'work_order_history.assigned_teamleader',
                'work_order_history.assign_to_technician',
                'users.id as user_id',
                'users.name as user_name',
            )
            ->leftJoin('users', 'users.id', '=', DB::raw('CASE 
                    WHEN work_order_history.status = "NEW" THEN work_order_history.status_changed_by 
                    WHEN work_order_history.status = "ACCEPTED" THEN work_order_history.status_changed_by 
                    WHEN work_order_history.status = "ASSIGNED_SP" THEN work_order_history.status_changed_by                     
                    WHEN work_order_history.status = "ACCEPTED_TECHNICIAN" THEN work_order_history.assign_to_technician
                    WHEN work_order_history.status = "STARTED" THEN work_order_history.assign_to_technician
                    WHEN work_order_history.status = "COMPLETED" THEN work_order_history.assign_to_technician
                    ELSE NULL 
                END'))
            ->where('work_order_history.work_order_id', '=', $request->id)
            ->get();

            // return view('workOrderProfile.index', compact('open_WO_DetailId', 'imageData', 'WoOrObImageBefore', 'WoOrObImageAfter', 'WoOrHistory'));
            return view('workOrderProfile.index', compact('open_WO_DetailId', 'woActivities', 'WoOrHistory'));
            
        } else {
            // Handle the case when no record is found
            // You can return an error message or redirect the user
            return response()->json(['error' => 'No record found with the provided ID'], 404);
        }
    }


    public function tempUpload(Request $request)
    {

        // Initialize uploadedFiles array or retrieve existing if any
        $uploadedFiles = $request->session()->get('uploadedFiles', []);
        
        if ($request->hasFile('file')) {
            

            $file = $request->file('file');

            // You can also customize the filename if needed
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('temp', $filename); // Store in temp directory

            // If you want to get the public URL for the uploaded file
            $url = Storage::url($path);

            $uploadedFiles[] = [
                'tempPath' => $path,
                'url' => $url,
            ];

            // Store temporary values in session or cache if needed
            $request->session()->put('uploadedFiles', $uploadedFiles);
            // $request->session()->put('tempUrl', $url);

            // logger("uploadedFiles: " . $uploadedFiles);

            // Return a response
            return response()->json([
                'message' => 'File uploaded successfully',
                'tempPath' => $path,
                'url' => $url
            ], 200);

        } else {
            return response()->json(['message' => 'No file uploaded'], 400);
        }
    }
    
    public function create(Request $request)
    {
        $userID = $this->user->id;
        $workOrderID = $request->id;
        $comment = $request->comment;

        // Retrieve uploaded files array from session or directly from $request if stored
        $uploadedFiles = $request->session()->get('uploadedFiles');

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'comment' => 'required',
                'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip', // Add validation rules for the file
            ],
            [
                'comment.required' => 'The "Comment" field cannot be empty.',
                'file.mimes' => 'The file must be a file of type: jpg, jpeg, png, pdf, doc, docx, zip.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Insert new comment
            $WOActivity = WorkOrderActivity::create([
                'work_order_id' => $workOrderID,
                'comments' => $comment,
                'comment_by' => $userID,
            ]);

            // Now you can access the id
            $WOActivityID = $WOActivity->id;

            // Ensure all queries successfully executed, commit the db changes
            DB::commit();


            // Ensure $uploadedFiles is an array and not empty
            if (!empty($uploadedFiles) && is_array($uploadedFiles)) {
                foreach ($uploadedFiles as $fileData) {
                    $tempPath = $fileData['tempPath'];
                    $url = $fileData['url'];

                    // Extract filename from $tempPath
                    $filename = pathinfo($tempPath, PATHINFO_BASENAME);

                    // Define the destination path with the filename
                    $destinationPath = 'public/attachments/' . $filename;

                    // Move the file from $tempPath to $destinationPath
                    try {
                        Storage::move($tempPath, $destinationPath);

                        // Get the URL of the moved file
                        $url = Storage::url($destinationPath);

                        // Insert new activity attachment
                        $WOActivityAttachment = WorkOrderActivityAttachment::create([
                            'url' => $url,
                            'wo_activity_id' => $WOActivityID,
                        ]);

                    } catch (\Exception $e) {
                        // Clear session or cache after use if temporary storage was used
                        $request->session()->forget('uploadedFiles');
                        logger('File move error: ' . $e->getMessage());
                        return response()->json(['message' => 'Error moving file'], 500);
                    }
                }

                // Clear session or cache after use if temporary storage was used
                $request->session()->forget('uploadedFiles');

                // return response()->json(['message' => 'Files processed successfully'], 200);
            }

            // Ensure all queries successfully executed, commit the db changes
            DB::commit();

            return response()->json([
                'success' => 'Files uploaded successfully.',
            ], 200);
        } catch (\Exception $e) {
            // If any queries fail, undo all changes
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function deleteComment(Request $request){
        
        $delete_comment_id = $request->delete_comment_id;

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Select user id from client
            $vendor = WorkOrderActivity::select('user_id')->where('id', $delete_comment_id)->delete();


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
