<?php

namespace App\Http\Controllers;

use App\Models\PushNotification;
use App\Models\NotificationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Carbon\Carbon;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestCategory;
use App\Models\ServiceRequestSubCategory;
use Notification;
use App\Notifications\SendEmailNotification;

class PushNotificationController extends Controller
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

    private function getPriorityLabel($priority)
    {
        $priorityLabels = [
            1 => 'Very High',
            2 => 'High',
            3 => 'Medium',
            4 => 'Low'
        ];
        return $priorityLabels[$priority] ?? 'Unknown';
    }

    private function getCategoryDetails($serviceRequest)
    {
        $category = ServiceRequestCategory::find($serviceRequest->sr_category_id);
        $subcategory = ServiceRequestSubCategory::find($serviceRequest->sr_sub_category_id);

        return ($category ? $category->name : 'Unknown') . ' - ' . ($subcategory ? $subcategory->name : 'Unknown');
    }

    private function sendEmailNotification($recipientEmail, $details)
    {
        Notification::route('mail', $recipientEmail)->notify(new SendEmailNotification($details));
    }

    public function sendEmailNewSR($serviceRequest, $workOrder)
    {

        $categoryDetails = $this->getCategoryDetails($serviceRequest);
        $priorityLabel = $this->getPriorityLabel($workOrder->priority);

        // send email to Team Leader
        $teamLeaders = User::whereHas('roles', function ($query) {
            $query->where('name', 'team_leader');
        })->get();

        $emails = $teamLeaders->pluck('email');

        $detailsTeamLeader = [
            'title' => "New Work Order Notification",
            'greeting' => "Hello Team Leader,",
            'body' => "You have a new task that requires your attention. Please review the job details and assign it to a suitable technician as soon as possible.",
            'work_order_no' => $workOrder->work_order_no ?? 'N/A',
            'type' => $categoryDetails,
            'description' => $serviceRequest->description,
            'client_remark' => $serviceRequest->remarks_by_client,
            'priority' => $priorityLabel,
            'due_date' => $workOrder->due_date,
            'actiontext' => "Assign Task Now",
            'actionurl' => "http://127.0.0.1:8000", // Adjust the URL as needed
            'lastline' => "Thank you for your prompt action. Let us know if you need any assistance.",
        ];

        foreach ($emails as $email) {
            $this->sendEmailNotification($email, $detailsTeamLeader );
        }

        // send email to client
        $client = User::find($serviceRequest->raise_by);

        $detailsClient = [
            'title' => "Service Request Notification",
            'greeting' => "Hello {$client->name},",
            'body' => "Your service request has been successfully submitted. Our team will review it and get back to you shortly.",
            'service_request_no' => $serviceRequest->service_request_no ?? 'N/A',
            'type' => $categoryDetails,
            'description' => $serviceRequest->description,
            'client_remark' => $serviceRequest->remarks_by_client,
            'priority' => $priorityLabel,
            'due_date' => $workOrder->due_date,
            'actiontext' => "Review Service Request",
            'actionurl' => "http://127.0.0.1:8000", // Adjust the URL as needed
            'lastline' => "Thank you for your prompt action. Let us know if you need any assistance.",
        ];

        $this->sendEmailNotification($client->email, $detailsClient);

        return "Email has been sent successfully!";
    }

    public function sendEmailCompletedSR($serviceRequest, $workOrder)
    {

        $categoryDetails = $this->getCategoryDetails($serviceRequest);
        $priorityLabel = $this->getPriorityLabel($workOrder->priority);

        // send email to client
        $client = User::find($serviceRequest->raise_by);

        $detailsClient = [
            'title' => "Service Request Completed Notification",
            'greeting' => "Dear {$client->name},",
            'body' => "We are pleased to inform you that your service request (SR No: {$serviceRequest->service_request_no}) has been successfully completed. If you have any further questions or require assistance, please do not hesitate to reach out.",
            'service_request_no' => $serviceRequest->service_request_no ?? 'N/A',
            'type' => $categoryDetails,
            'description' => $serviceRequest->description,
            'client_remark' => $serviceRequest->remarks_by_client,
            'priority' => $priorityLabel,
            'due_date' => $workOrder->due_date,
            'actiontext' => "Review Service Request",
            'actionurl' => "http://127.0.0.1:8000", // Adjust the URL as needed
            'lastline' => "Thank you for your prompt action. Let us know if you need any assistance.",
        ];

        $this->sendEmailNotification($client->email, $detailsClient);

        return "Email has been sent successfully!";
    }

    public function sendEmailNewWO($technician_id, $work_order_id)
    {

        $technician = User::find($technician_id);
        $work_order = WorkOrder::find($work_order_id);
        $service_request = ServiceRequest::where('work_order_id', $work_order_id)->first();

        $categoryDetails = $this->getCategoryDetails($service_request);
        $priorityLabel = $this->getPriorityLabel($work_order->priority);

        $detailsTechnician = [
            'title' => "New Work Order Notification",
            'greeting' => "Hello {$technician->name},",
            'body' => "You have a new task that requires your attention. Please review the task details as soon as possible.",
            'work_order_no' => $work_order->work_order_no ?? 'N/A',
            'type' => $categoryDetails,
            'description' => $service_request->description,
            'client_remark' => $service_request->remarks_by_client,
            'priority' => $priorityLabel,
            'due_date' => $work_order->due_date,
            'actiontext' => "Check Task Now",
            'actionurl' => "http://127.0.0.1:8000", // Adjust the URL as needed
            'lastline' => "Thank you for your prompt action. Let us know if you need any assistance.",
        ];

        $this->sendEmailNotification($technician->email, $detailsTechnician);

        return "Email has been sent successfully!";
    }

    public function sendEmailUpdateWO($technician_id, $work_order_id)
    {

        $technician = User::find($technician_id);
        $workOrder = WorkOrder::find($work_order_id);
        $serviceRequest = ServiceRequest::where('work_order_id', $work_order_id)->first();

        $categoryDetails = $this->getCategoryDetails($serviceRequest);
        $priorityLabel = $this->getPriorityLabel($workOrder->priority);

        $detailsTechnician = [
            'title' => "New Work Order Notification",
            'greeting' => "Hello {$technician->name},",
            'body' => "You have a new task that requires your attention. Please review the task details as soon as possible.",
            'work_order_no' => $workOrder->work_order_no ?? 'N/A',
            'type' => $categoryDetails,
            'description' => $serviceRequest->description,
            'client_remark' => $serviceRequest->remarks_by_client,
            'priority' => $priorityLabel,
            'due_date' => $workOrder->due_date,
            'actiontext' => "Check Task Now",
            'actionurl' => "http://127.0.0.1:8000", // Adjust the URL as needed
            'lastline' => "Thank you for your prompt action. Let us know if you need any assistance.",
        ];

        $this->sendEmailNotification($technician->email, $detailsTechnician);

        return "Email has been sent successfully!";
    }

    public function sendPushNotification($request) 
    {    
        $title  = $request['title'] ;
        $msg    = $request['message'] ;
        $id     = $request['user_id'] ;

        $getToken = PushNotification::select(['token', 'user_id'])
            ->where('user_id', '=', $id)
            ->get()
        ;

        if(count($getToken) !== 0){
            try {
                $firebase   = (new Factory)->withServiceAccount(__DIR__.'/../../../config/firebase_credentials.json');
                $messaging  = $firebase->createMessaging();
                $message    = CloudMessage::fromArray([
                    'notification' => [
                        'title' => $title,
                        'body' => $msg
                    ],
                    // 'topic' => 'global',     // send notification to all user
                    'token' => $getToken[0]->token // send notification to specific user
                ]);

                $messaging->send($message);

                // Ensure all queries successfully executed, commit the db changes
                DB::commit();

                return response()->json(['message' => 'Push notification sent successfully'], 200);
            
            } catch (\Exception $e) {

                // If any queries fail, undo all changes
                DB::rollback();

                return response()->json(['error' => 'Push notification failed to send!'], 422);
            }
        } else {
            // Ensure all queries successfully executed, commit the db changes
            DB::commit();

            return response()->json(['message' => 'Data saved'], 200);
        }
    }

    public function storeDeviceToken(Request $request){

        $token = $request['firebase_token'];
        $user_id = $request['user_id'];

        try {
            $store = PushNotification::updateOrCreate(
                ['token' => $token], // Search criteria
                ['user_id' => $user_id] // Attributes to update
            );

            // Ensure all queries successfully executed, commit the db changes
            DB::commit();

            return response()->json([
                "success"   => "success",
            ], 200);
        } catch (\Exception $e) {

            // If any queries fail, undo all changes
            DB::rollback();

            return response()->json(['error' => 'device token not saved!'], 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notification.create');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PushNotification  $pushNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy(PushNotification $pushNotification)
    {
        //
    }

    /**
     * Display the notification message from notification_history table.
     */
    public function notificationHistory(Request $request)
    {
        $notificationHistory = NotificationHistory::selectRaw('notification_content, status, user_id, created_at')
        ->where('user_id', $this->user->id)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $notificationHistory->transform(function ($nHistory) {
            // Convert to Dubai time
            $dubaiTime = Carbon::parse($nHistory->created_at)->timezone('Asia/Dubai');

            // Add new formatted date, month, and year fields to the object
            $nHistory->dubai_created_at = $dubaiTime->toDateTimeString();
            $nHistory->date = $dubaiTime->format('d');
            $nHistory->month = $dubaiTime->format('F');
            $nHistory->year = $dubaiTime->format('Y');

            return $nHistory;
        });

        logger($notificationHistory);

        return response()->json([
            'notificationHistory' => $notificationHistory,
        ]);
    }
}