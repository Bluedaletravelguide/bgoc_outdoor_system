<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
//
use App\Models\User;
use Spatie\Permission\Models\Role;
use Notification;
use App\Notifications\SendEmailNotification;

class HomeController extends Controller
{

    public function sendnotification($srStatus){

        if($srStatus  == 'NEW'){

            $teamLeaders = User::whereHas('roles', function ($query) {
                $query->where('name', 'team_leader');
            })->get();
    
            $emails = $teamLeaders->pluck('email');

            $details = [
                'greeting' => 'Hello Team Leader,',
                'body' => "You have a new task that requires your attention. Please review the job details and assign it to a suitable technician as soon as possible.",
                'actiontext' => 'Assign Task Now',
                'actionurl' => 'http://127.0.0.1:8000', // Adjust the URL as needed
                'lastline' => 'Thank you for your prompt action. Let us know if you need any assistance.',
            ];

            // Notification::send($user, new SendEmailNotification($details));
            // Notification::send("2022821052@student.uitm.edu.my", new SendEmailNotification($details));

            foreach ($emails as $email) {
                // logger("User tmmmmmm: {$user->name}, Email: {$user->email}");
                Notification::route('mail', $email)->notify(new SendEmailNotification($details));
            }

            return "Email has been sent successfully!";

        } else if($srStatus  == 'ACCEPTED'){

            $details = [
                'greeting' => 'Hello Team Leader,',
                'body' => "You have a new task that requires your attention. Please review the job details and assign it to a suitable technician as soon as possible.",
                'actiontext' => 'Assign Task Now',
                'actionurl' => 'http://127.0.0.1:8000', // Adjust the URL as needed
                'lastline' => 'Thank you for your prompt action. Let us know if you need any assistance.',
            ];

            // Notification::send($user, new SendEmailNotification($details));
            // Notification::send("2022821052@student.uitm.edu.my", new SendEmailNotification($details));

            foreach ($emails as $email) {
                // logger("User tmmmmmm: {$user->name}, Email: {$user->email}");
                Notification::route('mail', $email)->notify(new SendEmailNotification($details));
            }

            return "Email has been sent successfully!";
        }
   }

//     //                                                          

//     public function getTeamLeaders()                                                                              
// {
//     $teamLeaders = User::whereHas('roles', function ($query) {
//         $query->where('id', 3);
//     })->get();                             

//     return response()->json($teamLeaders); // Return as JSON (or pass to a view)                                                                                 
// }                                                  

    /**
     * Create a new controller instance.         
     *
     * @return void
     */                         
    public function __construct()                                     
    {                                                                
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Log::info("home controller");
        $servicerequest_new = ServiceRequest::where('status','new')
                                            ->count();

        $servicerequest_in_progress = ServiceRequest::where('status','accepted')
                                                    ->count();

        // $servicerequest_reject = ServiceRequest::where('status','rejected')
        //                                             ->count();
        
        $servicerequest_complete = ServiceRequest::where('status','closed')
                                                    ->count();

        
        $startDate = Carbon::now()->subDays(20);
        $startDate1D = Carbon::now()->subDays(1)->startOfDay();
        $endDate = Carbon::now();

        $dataLast10Days = ServiceRequest::where('created_at', '>=', $startDate)
                                        ->where('created_at', '<=', $endDate)
                                        ->get();

        $groupedData = $dataLast10Days->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('Y-m-d');
        })->map(function($group) {
            return $group->count();
        });

        // $groupedCategories = ServiceRequest::leftJoin('sr_category', 'sr_category.id', '=', 'service_request.sr_category_id')
        //                                 ->groupBy('sr_category_id')
        //                                 ->selectRaw('sr_category_id, COUNT(*) as count')
        //                                 ->pluck('count', 'sr_category_id');

        $groupedCategories = DB::table('service_request')
                                ->join('sr_category', 'service_request.sr_category_id', '=', 'sr_category.id')
                                ->select('sr_category.name', DB::raw('COUNT(service_request.id) as order_count'))
                                ->groupBy('sr_category.name')
                                ->get()
                                ->pluck('order_count', 'name');

        $groupedStatus = ServiceRequest::groupBy('status')
                                        ->selectRaw('status, COUNT(*) as count')
                                        ->pluck('count', 'status');

        $highAttention = WorkOrder::where('created_at', '<', $startDate1D)
                                    ->where('priority', '=', 'High')
                                    ->whereNull('assigned_teamleader')->get();

        // dump($startDate);
        // dump($endDate);
        // dd($groupedData);

        return view('home.index', [ ], compact('servicerequest_new', 'servicerequest_in_progress', 'servicerequest_complete', 
        'groupedData', 'groupedCategories', 'groupedStatus', 'highAttention'));
    }
}
