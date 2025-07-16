<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class EmployeesController extends Controller
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
    public function index()
    {   
        if (is_null($this->user) || !$this->user->can('employee.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any employee. Contact system admin for access !');
        }

        $Employees = Employee::select()->get();
        $Roles = Role::select('id','name')->get();
        $Users = User::select('id','name','username')->where('type','=','employee')->get();
        // dd($Employees);
        
        return view('employees.index', [
            'Employees' => $Employees,
            'Roles' => $Roles,
            'Users' => $Users,
        ]);

    }

    public function Create(Request $request): RedirectResponse
    {
        // dd($request);
        $this->validate($request, [
            'name' => 'required',
            'contact' => 'required',
            'position' => 'required',
        ]);

        $input = $request->all();

        $Employees = Employee::create($input);

        return redirect()->route('employees.index');

    }

    public function list(Request $request)
    {
     /**
     * Show the employee users list.
     */
        $role = $request->input('role');
        $status = $request->input('status');

        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'username',
            3 => 'contact',
            4 => 'position',
            6 => 'status',
            7 => 'action',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $columns[$orderColumnIndex];
        $orderDirection = $request->input('order.0.dir');

        $query = Employee::leftJoin('users', 'employees.user_id', '=', 'users.id')
            ->select('employees.id as id','users.username','employees.name','employees.contact','employees.position', 'employees.status as status','users.id as user')
            ->orderBy($orderColumnName, $orderDirection);

        if ($role == "" && $status == "") {
            $query->get(); // No additional role filter for "All"
        }else if ($role != "" && $status == "") {
            $query->where('users.username', '=', $role); 
        }else if ($role == "" && $status != "") {
            $query->where('employees.status','=', $status); 
        } else {
            $query->where('users.username', '=', $role)
            ->where('employees.status','=', $status);
        }

        // Get total records count
        $totalData = $query->count();

        $searchValue = trim(strtolower($request->input('search.value')));

        if (!empty($searchValue)) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('users.username', 'LIKE', "%{$searchValue}%")
                    ->orWhere('employees.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('employees.contact', 'LIKE', "%{$searchValue}%")
                    ->orWhere('employees.position', 'LIKE', "%{$searchValue}%")
                    ->orWhere('users.status', 'LIKE', "%{$searchValue}%");
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
                'name' => $d->name,
                'username' => $d->username,
                'contact' => $d->contact,
                'position' => $d->position,
                'status' => $d->status,
                'user' => $d->user,
                'action' => $d->id,
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

    public function edit(Request $request): RedirectResponse
    {

        $this->validate($request, [
            'name' => 'required',
            'contact' => 'required',
            'position' => 'required',
        ]);
        
        if (is_null($request->user_id) && $request->status == '0'){
            $input = $request->all();
        }elseif (is_null($request->user_id) && $request->status == '1') {
            $request->merge(['status' => "0"]);
            $input = $request->all();
        }else{
            $request->merge(['status' => "1"]);
            $input = $request->all();
        }

        // $Employee = Employee::find($id);
        $Employee->update($input);


        // return redirect()->route('employees.index');
        return back();

    }
    
    public function destroy(Request $request, string $id): RedirectResponse
    {
        // dd($request);

        if ($request->status == '0') {
            // abort(403, 'Sorry !! Account is already inactive !');
        }
        else{
            $User = User::find($request->user);
            $Employee = Employee::find($id);
            $now = Carbon::now();
            $input = array(
                'user_id' => null,
                'status' => '0',
                'deleted_at' => $now->toDateTimeString()
            );
            $Employee->update($input);
            $User->delete();
        }


        // return redirect()->route('employees.index');
        return back();
    }

}
