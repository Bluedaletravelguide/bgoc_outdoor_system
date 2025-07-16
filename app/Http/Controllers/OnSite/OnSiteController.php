<?php

namespace App\Http\Controllers\OnSite;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\OnsiteTeamMembers;
use App\Models\OnsiteTeam;
use App\Models\Employee;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class OnSiteController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function Index()
    {   
        if (is_null($this->user) || !$this->user->can('employee.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any on-site team. Contact system admin for access !');
        }

        $Contract = OnsiteTeam::rightJoin('contracts', 'onsite_team.contract_id', '=', 'contracts.id')
        ->select('contracts.id as id','contract_prefix','onsite_team.team_name')
        ->get();
        $Teams = OnsiteTeam::select()->get();
        $Teamlist = OnsiteTeamMembers::rightJoin('onsite_team','onsite_team.id','=','onsite_team_members.onsite_team_id')
            ->select(DB::raw('onsite_team.id as id'),'onsite_team.team_name as onsite_team_id','onsite_team_members.onsite_team_id as onsite_team')
            ->get();
        $Members = OnsiteTeamMembers::rightJoin('employees', 'employees.id', '=', 'onsite_team_members.employee_id')
            ->select(DB::raw('DISTINCT employees.id AS id'), 'employees.name AS name' , 'onsite_team_members.employee_id')
            ->get();
        $Employee = Employee::leftJoin('onsite_team_members', 'onsite_team_members.employee_id', '=', 'employees.id')
        ->select('employees.id as id','employees.name as name','onsite_team_members.onsite_team_id')
        ->where('employees.status','=','1')
        ->get();
        
        // dd($Employee);
        
        return view('onSite.index', [
            'Members' => $Members,
            'Teams' => $Teams,
            'Teamlist' => $Teamlist,
            'Contract' => $Contract,
            'Employee' => $Employee,
        ]);

    }

    public function teamsList(Request $request)
    {
     /**
     * Show the employee users list.
     */
        $role = $request->input('role');
        $status = $request->input('status');

        $columns = array(
            0 => 'team_name',
            1 => 'contract_id',
            3 => 'type',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $columns[$orderColumnIndex];
        $orderDirection = $request->input('order.0.dir');

        $query = OnsiteTeam::leftJoin('contracts', 'onsite_team.contract_id', '=', 'contracts.id')
            ->select('onsite_team.id as id','onsite_team.team_name','contract_prefix as contract_id','onsite_team.type')
            ->orderBy($orderColumnName, $orderDirection);

        // Get total records count
        $totalData = $query->count();

        $searchValue = trim(strtolower($request->input('search.value')));

        if (!empty($searchValue)) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('onsite_team.team_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('contract_prefix', 'LIKE', "%{$searchValue}%")
                    ->orWhere('onsite_team.type', 'LIKE', "%{$searchValue}%");
            });
        }

        // Get total filtered records count
        $totalFiltered = $query->count();

        // Apply pagination
        $filteredData = $query->skip($start)->take($limit)->get();

        $data = array();

        foreach ($filteredData as $d) {
            $nestedData = array(
                'id' => $d->id,
                'team_name' => $d->team_name,
                'contract_id' => $d->contract_id,
                'type' => $d->type,
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

    public function memberslist(Request $request)
    {
     /**
     * Show the employee users list.
     */

        $columns = array(
            0 => 'employee_id',
            1 => 'onsite_team_id',
            3 => 'id',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $columns[$orderColumnIndex];
        $orderDirection = $request->input('order.0.dir');

        $data = OnsiteTeamMembers::leftJoin('employees', 'employees.id', '=', 'onsite_team_members.employee_id')
        ->leftJoin('onsite_team', 'onsite_team.id', '=', 'onsite_team_members.onsite_team_id')
        ->select('employees.name as employee_id','onsite_team.team_name as onsite_team_id','onsite_team.id')
        ->where('employees.status','=','1')
        ->groupBy('employees.name','onsite_team.team_name','onsite_team.id')->get();

        // Organize the data into an array grouped by sr_category
        $groupedData = $data->groupBy('onsite_team_id')->map(function ($items) {
            return $items->pluck('employee_id')->toArray();
        });

        $slicedData = $groupedData->slice($start, $limit);;

        $finalData = array();
        $totalData = count($groupedData);
        $totalFiltered = count($groupedData);

        foreach ($slicedData as $onsite_team_id => $employee_id) {
            $originalData = $data->firstWhere('onsite_team_id', $onsite_team_id); // Fetch the original data
            $nestedData = array(
                'id' => optional($originalData)->id, // Use optional() to avoid calling a member function on null
                'onsite_team_id' => $onsite_team_id,
                'employee_id' => $employee_id,
            );
            $query[] = $nestedData;
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $query,
        );


        echo json_encode($json_data);
    }

    public function teamsCreate(Request $request): RedirectResponse
    {
        // dd($request);
        $this->validate($request, [
            'team_name' => 'required',
            'contract_id' => 'required',
            'type' => 'required',
        ]);

        $input = $request->all();

        $OnsiteTeam = OnsiteTeam::create($input);

        return back();

    }

    public function teamsUpdate(Request $request, $id): RedirectResponse
    {
        // dd($request);
        $this->validate($request, [
            'team_name' => 'required',
            'contract_id' => 'required',
            'type' => 'required',
        ]);
        $input = $request->all();
        $OnsiteTeam = OnsiteTeam::find($id);
        $OnsiteTeam->update($input);


        // return redirect()->route('onSite.index');
        return back();

    }

    public function membersCreate(Request $request): RedirectResponse
    {
        // dd($request);
        $this->validate($request, [
            'onsite_team_id' => 'required',
            'employee_id' => 'required',
        ]);
        $Team = $request->onsite_team_id;
        $Employee = $request->employee_id;

        $employeeAssignments = []; // Declare an empty array

        foreach($Employee as $Members){
            $input = array(
                'onsite_team_id' => $Team,
                'employee_id' => $Members,
            );
        
            $employeeAssignments = OnsiteTeamMembers::create($input);; // Push each employee data to the array
        }

        return redirect()->route('onSite.index');

    }

    public function membersUpdate(Request $request, $id): RedirectResponse
    {
        // dd($request);
        $this->validate($request, [
            'onsite_team_id' => 'required',
            'employee_id' => 'required',
        ]);
        
        $Team = $request->onsite_team_id;
        $Employee = $request->employee_id;
        foreach ($Employee as $employeeId) {
            OnsiteTeamMembers::where('onsite_team_id', $Team)->delete();
        }
        // dd($Employee);
        $employeeAssignments = []; // Declare an empty array
        foreach($Employee as $Members){
            $input = array(
                'onsite_team_id' => $Team,
                'employee_id' => $Members,
            );
            $employeeAssignments = OnsiteTeamMembers::create($input);; // Push each employee data to the array
        }

        return redirect()->route('onSite.index');

    }

    public function teamsDestroy(string $id): RedirectResponse
    {
        $OnsiteTeam = OnsiteTeam::find($id);
        $OnsiteTeam->delete();

        return redirect()->route('onSite.index');
        // return back();
    }
}