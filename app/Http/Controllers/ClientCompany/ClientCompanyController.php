<?php

namespace App\Http\Controllers\ClientCompany;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\ClientCompany;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ClientCompanyController extends Controller
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
     * Show the client company page.
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('client.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any client. Contact system admin for access !');
        }

        return view('client_company.index', []);
    }

    /**
     * Show the client company list.
     */
    public function list(Request $request)
    {
        // Set the time zone to Dubai
        $today = Carbon::today('Asia/Dubai');

        $status = $request->input('status');
        $type = $request->input('type');

        $columns = array(
            0 => 'company_prefix',
            1 => 'name',
            2 => 'address',
            3 => 'phone',
            4 => 'project_status',
            5 => 'project_type',
            6 => 'id',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $columns[$orderColumnIndex];
        $orderDirection = $request->input('order.0.dir');

        $query = ClientCompany::leftJoin('projects', 'projects.client_company_id', '=', 'client_company.id')
            ->select('client_company.*', 'projects.from_date as from_date', 'projects.to_date as to_date', 'projects.type as project_type', 'projects.client_company_id')
            ->where('status', '1')
            ->orderBy($orderColumnName, $orderDirection);

        if ($type != "all") {
            $query->where('projects.type', $type);
        }

        // Filter by project status if $status is provided
        if ($status === "Active" || $status === "Inactive") {
            $query->where(function ($query) use ($status, $today) {
                if ($status === "Active") {
                    $query->whereDate('projects.from_date', '<=', $today)
                        ->whereDate('projects.to_date', '>=', $today);
                } elseif ($status === "Inactive") {
                    // $query->where(function ($query) {
                    $query->where(function ($query) use ($today) {
                        $query->whereDate('projects.from_date', '>', $today)
                            ->orWhereDate('projects.to_date', '<', $today);
                    })
                        ->orWhereNull('projects.from_date')
                        ->orWhereNull('projects.to_date');;
                }
            });
        }

        // Get total records count
        $totalData = $query->count();

        $searchValue = trim(strtolower($request->input('search.value')));

        if (!empty($searchValue)) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('client_company.company_prefix', 'LIKE', "%{$searchValue}%")
                    ->orWhere('client_company.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('client_company.address', 'LIKE', "%{$searchValue}%")
                    ->orWhere('client_company.phone', 'LIKE', "%{$searchValue}%")
                    ->orWhere('projects.type', 'LIKE', "%{$searchValue}%");
            });
        }

        // Get total filtered records count
        $totalFiltered = $query->count();

        // Apply pagination
        $filteredData = $query->skip($start)->take($limit)->get();

        $data = array();

        foreach ($filteredData as $d) {
            $project_status = ($d->from_date <= $today && $d->to_date >= $today) ? 'Active' : 'Inactive';

            $nestedData = array(
                'company_prefix'    => $d->company_prefix,
                'name'              => $d->name,
                'address'           => $d->address,
                'phone'             => $d->phone,
                'project_status'   => $project_status,
                'project_type'     => $d->project_type,
                'id'                => $d->id,
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
     * Create client company.
     */
    public function create(Request $request)
    {
        $prefix     = $request->prefix;
        $name       = $request->name;
        $address    = $request->address;
        $phone      = $request->phone;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'prefix' => [
                    'required',
                    'string',
                    'max:4',
                    'unique:client_company,company_prefix',
                    'regex:/^\S*$/', // No spaces allowed
                ],
                'name' => [
                    'required',
                    'string',
                    'unique:client_company,name',
                    'max:255',
                ],
                'address' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'phone' => [
                    'required',
                    'regex:/^\+?[0-9]+$/',
                    'max:255',
                ],
            ],
            [
                'prefix.required' => 'The "Company Prefix" field is required.',
                'prefix.string' => 'The "Company Prefix" must be a string.',
                'prefix.max' => 'The "Company Prefix" must not be greater than :max characters.',
                'prefix.unique' => 'The "Company Prefix" is already been taken.',
                'prefix.regex' => 'The "Company Prefix" must not contain any spaces.',

                'name.required' => 'The "Company Name" field is required.',
                'name.string' => 'The "Company Name" must be a string.',
                'name.max' => 'The "Company Name" must not be greater than :max characters.',

                'address.required' => 'The "Address" field is required.',
                'address.string' => 'The "Address" must be a string.',
                'address.max' => 'The "Address" must not be greater than :max characters.',

                'phone.required' => 'The "Phone No." field is required.',
                'phone.regex' => 'The "Phone No." field must only contain "+" symbol and numbers.',
                'phone.max' => 'The "Phone No." field must not be greater than :max characters.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Insert new client company
            $user = ClientCompany::create([
                'company_prefix'    => $prefix,
                'name'              => $name,
                'address'           => $address,
                'phone'             => $phone,
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
     * Edit client company.
     */
    public function edit(Request $request)
    {
        $prefix                 = $request->prefix;
        $name                   = $request->name;
        $original_company_id    = $request->original_company_id;
        $address                = $request->address;
        $phone                  = $request->phone;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'prefix' => [
                    'required',
                    'string',
                    'max:4',
                    Rule::unique('client_company', 'company_prefix')->ignore($original_company_id), // Exclude original value but still checks for uniqueness
                    'regex:/^\S*$/', // No spaces allowed
                ],
                'name' => [
                    'required',
                    'string',
                    Rule::unique('client_company', 'name')->ignore($original_company_id), // Exclude original value but still checks for uniqueness
                    'max:255',
                ],
                'original_company_id' => [
                    'required',
                    'integer',
                    'exists:client_company,id,status,1', // Ensure company status is 1 (active)
                ],
                'address' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'phone' => [
                    'required',
                    'regex:/^\+?[0-9]+$/',
                    'max:255',
                ],
            ],
            [
                'prefix.required' => 'The "Company Prefix" field is required.',
                'prefix.string' => 'The "Company Prefix" must be a string.',
                'prefix.max' => 'The "Company Prefix" must not be greater than :max characters.',
                'prefix.unique' => 'The "Company Prefix" is already been taken.',
                'prefix.regex' => 'The "Company Prefix" must not contain any spaces.',

                'name.required' => 'The "Company Name" field is required.',
                'name.string' => 'The "Company Name" must be a string.',
                'name.max' => 'The "Company Name" must not be greater than :max characters.',
                'name.unique' => 'The "Company Name" is already been taken.',

                'original_company_id.exists' => 'The selected Client Company was deleted from the system!',

                'address.required' => 'The "Address" field is required.',
                'address.string' => 'The "Address" must be a string.',
                'address.max' => 'The "Address" must not be greater than :max characters.',

                'phone.required' => 'The "Phone No." field is required.',
                'phone.regex' => 'The "Phone No." field must only contain "+" symbol and numbers.',
                'phone.max' => 'The "Phone No." field must not be greater than :max characters.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Update client company
            ClientCompany::where('id', $original_company_id)
                ->update([
                    'company_prefix'    => $prefix,
                    'name'              => $name,
                    'address'           => $address,
                    'phone'             => $phone,
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
     * Delete client company.
     */
    public function delete(Request $request)
    {
        // Get the current UTC time
        $current_UTC = Carbon::now('UTC');

        $delete_company_id = $request->delete_company_id;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'delete_company_id' => [
                    'required',
                    'integer',
                    'exists:client_company,id',
                ],
            ],
            [
                'delete_company_id.exists' => 'The client company cannot be found.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Update stus to 0 as deleted (soft delete)
            ClientCompany::where('id', $delete_company_id)
                ->update([
                    'status'        => '0',
                    'deleted_at'    => $current_UTC
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
}
