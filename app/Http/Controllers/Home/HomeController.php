<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Billboard;
use App\Models\BillboardBooking;

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

        $billboard_total = Billboard::count();

        $billboard_active = Billboard::where('status', 1)->count();
        
        $billboard_booking_total = BillboardBooking::count();

        $billboard_booking_active = BillboardBooking::where('status', 'ongoing')->count();

        
        $startDate = Carbon::now()->subDays(20);
        $startDate1D = Carbon::now()->subDays(1)->startOfDay();
        $endDate = Carbon::now();

        $dataLast10Days = Billboard::where('created_at', '>=', $startDate)
                                        ->where('created_at', '<=', $endDate)
                                        ->get();

        $groupedData = $dataLast10Days->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('Y-m-d');
        })->map(function($group) {
            return $group->count();
        });

        $billboard_status_counts = Billboard::select('status', DB::raw('count(*) as total'))
                                ->groupBy('status')
                                ->pluck('total', 'status');
        
        // Map status values to labels
        $billboard_status = [];
        foreach ($billboard_status_counts as $key => $value) {
            $label = $key == 1 ? 'Active' : 'Inactive';
            $billboard_status[$label] = $value;
        }

        $billboard_status_counts = BillboardBooking::select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->pluck('total', 'status')
        ->toArray();

        // Map DB status to readable labels
        $labelMap = [
            'ongoing' => 'Ongoing',
            'pending_install' => 'Pending Install',
            'pending_payment' => 'Pending Payment',
        ];

        $booking_status = [];
        foreach ($billboard_status_counts as $status => $count) {
            $label = $labelMap[$status] ?? ucfirst(str_replace('_', ' ', $status));
            $booking_status[$label] = $count;
        }

        $attentions = Billboard::where('created_at', '<', $startDate1D)->get();

        logger('bb total:', ['count' => $billboard_total]);
        logger('bb total:', ['count' => $billboard_active]);
        // logger('bk total: ' , $billboard_booking_total);
        // logger('bk active: ' , $billboard_booking_active);
        // logger('bb status: ' , $billboard_total);
        // logger('bk status: ' , $billboard_total);

        return view('home.index', [ ], compact('billboard_total', 'billboard_active', 'billboard_booking_total', 
        'billboard_booking_active', 'billboard_status', 'booking_status', 'attentions'));
    }
}
