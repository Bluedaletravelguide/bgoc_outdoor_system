<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use App\Models\Client;
use App\Models\ClientCompany;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
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
     * Show the users page.
     */
    public function index()
    {
        $client_companies = ClientCompany::select('id', 'name')->get();

        return view('users.index', [
            'client_companies'  => $client_companies,
        ]);
    }

    public function listUser(Request $request){

    }

    /**
     * Show the users list.
     */
    public function list(Request $request)
    {
        logger('user masok sini');
        
        $role = $request->input('role');

        $columns = array(
            0 => 'name',
            1 => 'username',
            2 => 'role',
            3 => 'email',
            4 => 'status',
            5 => 'last_login_at',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $columns[$orderColumnIndex];
        $orderDirection = $request->input('order.0.dir');

        $query = User::with('roles')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role')
            ->orderBy($orderColumnName, $orderDirection);

        // Get total records count
        $totalData = $query->count();

        $searchValue = trim(strtolower($request->input('search.value')));

        if (!empty($searchValue)) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('users.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('users.username', 'LIKE', "%{$searchValue}%")
                    ->orWhereHas('roles', function ($roleQuery) use ($searchValue) {
                        $roleQuery->where('name', 'LIKE', "%{$searchValue}%");
                    })
                    ->orWhere('users.email', 'LIKE', "%{$searchValue}%")
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
                'name' => $d->name,
                'username' => $d->username,
                'role' => $d->roles->implode('name', ', '),
                'email' => $d->email,
                // 'last_login_at' => $d->last_login_at ? $d->last_login_at->timezone('Asia/Dubai')->format('Y-m-d H:i:s') : null,
                'id' => $d->id,
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
     * Create user.
     */
    public function create(Request $request)
    {
        $name       = $request->name;
        $username   = $request->username;
        $role       = $request->role;
        $employee   = $request->employee;
        $password   = $request->password;
        $email      = $request->email;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'username' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:users,username',
                    'regex:/^\S*$/', // No spaces allowed
                ],
                'role' => [
                    'required',
                    'string',
                    'in:superadmin,employee_occ_admin,employee_occ_operator,employee_supervisor,employee_technician',
                ],
                'employee' => [
                    'required',
                    'integer',
                    'exists:employees,id,user_id,NULL',
                ],
                'password' => [
                    'required',
                    'string',
                    'min:6',
                    'confirmed'
                ],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                ],
            ],
            [
                'name.required' => 'The "System Display Name" field is required.',
                'name.string' => 'The "System Display Name" must be a string.',
                'name.max' => 'The "System Display Name" must not be greater than :max characters.',

                'username.required' => 'The "System Login Username" field is required.',
                'username.string' => 'The "System Login Username" must be a string.',
                'username.max' => 'The "System Login Username" must not be greater than :max characters.',
                'username.unique' => 'The "System Login Username" is already been taken.',
                'username.regex' => 'The "System Login Username" must not contain any spaces.',

                'role.required' => 'The "Role" field is required.',
                'role.string' => 'The "Role" must be a string.',
                'role.max' => 'The "Role" must not be greater than :max characters.',

                'employee.exists' => 'The employee cannot be found or already associated with an user account.',

                'password.confirmed' => 'The password confirmation does not match.',

                'email.required' => 'The "Email" field is required.',
                'email.string' => 'The "Email" field must be a string.',
                'email.email' => 'The "Email" field must be a valid email address.',
                'email.max' => 'The "Email" field must not be greater than :max characters.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Insert new system user
            $user = User::create([
                'name'      => $name,
                'username'  => $username,
                'email'     => $email,
                'type'      => "employee",
                'status'    => "1",
                'password'  => Hash::make($password),
            ]);

            $role_name = Role::where('name', $role)->first();

            // Update employee user_id
            Employee::where('id', $employee)
                ->update([
                    'user_id'   => $user->id
                ]);

            // Update user role
            $user->syncRoles([$role_name]);

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
     * Edit user.
     */
    public function edit(Request $request)
    {
        $name               = $request->name;
        $username           = $request->username;
        $original_username  = $request->original_username;
        $role               = $request->role;
        $email              = $request->email;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'username' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'original_username' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'role' => [
                    'required',
                    'string',
                    'in:superadmin,employee_occ_admin,employee_occ_operator,employee_supervisor,employee_technician',
                ],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                ],
            ],
            [
                'name.required' => 'The "System Display Name" field is required.',
                'name.string' => 'The "System Display Name" must be a string.',
                'name.max' => 'The "System Display Name" must not be greater than :max characters.',

                'username.required' => 'The "System Login Username" field is required.',
                'username.string' => 'The "System Login Username" must be a string.',
                'username.max' => 'The "System Login Username" must not be greater than :max characters.',

                'role.required' => 'The "Role" field is required.',
                'role.string' => 'The "Role" must be a string.',
                'role.max' => 'The "Role" must not be greater than :max characters.',

                'email.required' => 'The "Email" field is required.',
                'email.string' => 'The "Email" field must be a string.',
                'email.email' => 'The "Email" field must be a valid email address.',
                'email.max' => 'The "Email" field must not be greater than :max characters.',
            ]
        );
        
        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            $user = User::where('username', $original_username)->first();
            $role_name = Role::where('name', $role)->first();

            // Handle the case where the user is not found
            if (!$user) {
                return response()->json(['error' => 'User not found.'], 404);
            }

            // Update user details
            User::where('username', $original_username)
                ->update([
                    'name'      => $name,
                    'username'  => $username,
                    'email'     => $email
                ]);

            // Update user role
            $user->syncRoles([$role_name]);

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
     * Delete user.
     */
    public function delete(Request $request)
    {
        $delete_user_id = $request->delete_user_id;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'delete_user_id' => [
                    'required',
                    'integer',
                    'exists:users,id',
                ],
            ],
            [
                'delete_user_id.exists' => 'The employee cannot be found.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Update employee user_id to null as removing the association of the deleted user account
            Employee::where('user_id', $delete_user_id)
                ->update([
                    'user_id'   => null
                ]);

            // Delete system user
            User::find($delete_user_id)->delete();

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
     * Create client user.
     */
    public function createClient(Request $request)
    {
        $name       = $request->name;
        $username   = $request->username;
        $role       = $request->role;
        $client     = $request->client;
        $password   = $request->password;
        $email      = $request->email;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'username' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:users,username',
                    'regex:/^\S*$/', // No spaces allowed
                ],
                'role' => [
                    'required',
                    'string',
                    'in:client_user',
                ],
                'client' => [
                    'required',
                    'integer',
                    'exists:clients,id,user_id,NULL',
                ],
                'password' => [
                    'required',
                    'string',
                    'min:6',
                    'confirmed'
                ],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                ],
            ],
            [
                'name.required' => 'The "System Display Name" field is required.',
                'name.string' => 'The "System Display Name" must be a string.',
                'name.max' => 'The "System Display Name" must not be greater than :max characters.',

                'username.required' => 'The "System Login Username" field is required.',
                'username.string' => 'The "System Login Username" must be a string.',
                'username.max' => 'The "System Login Username" must not be greater than :max characters.',
                'username.unique' => 'The "System Login Username" is already been taken.',
                'username.regex' => 'The "System Login Username" must not contain any spaces.',

                'role.required' => 'The "Role" field is required.',
                'role.string' => 'The "Role" must be a string.',
                'role.max' => 'The "Role" must not be greater than :max characters.',

                'client.exists' => 'The client cannot be found or already associated with an user account.',

                'password.confirmed' => 'The password confirmation does not match.',

                'email.required' => 'The "Email" field is required.',
                'email.string' => 'The "Email" field must be a string.',
                'email.email' => 'The "Email" field must be a valid email address.',
                'email.max' => 'The "Email" field must not be greater than :max characters.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Insert new system user
            $user = User::create([
                'name'      => $name,
                'username'  => $username,
                'email'     => $email,
                'type'      => "client",
                'status'    => "1",
                'password'  => Hash::make($password),
            ]);

            $role_name = Role::where('name', $role)->first();

            // Update client user_id
            Client::where('id', $client)
                ->update([
                    'user_id'   => $user->id
                ]);

            // Update user role
            $user->syncRoles([$role_name]);

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
     * Create client user - get list of clients.
     */
    public function createGetClients(Request $request)
    {
        $type = $request->type;

        $client_company_list = ClientCompany::get();
        $clients_list = Client::whereNull('user_id');

        if ($type == "default") {
            $default_client = $client_company_list->first();
            $clients_list = $clients_list->where('company_id', $default_client->id);
        } else {
            $clients_list = $clients_list->where('company_id', $request->client_id);
        }

        $clients_list = $clients_list->get();

        return response()->json(["client_company_list" => $client_company_list, "clients_list" => $clients_list], 200);
    }

    

    /**
     * Delete client user.
     */
    public function deleteClient(Request $request)
    {
        $delete_user_id = $request->delete_user_id;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'delete_user_id' => [
                    'required',
                    'integer',
                    'exists:users,id',
                ],
            ],
            [
                'delete_user_id.exists' => 'The client cannot be found.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Update client user_id to null as removing the association of the deleted user account
            Client::where('user_id', $delete_user_id)
                ->update([
                    'user_id'   => null
                ]);

            // Delete system user
            User::find($delete_user_id)->delete();

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
