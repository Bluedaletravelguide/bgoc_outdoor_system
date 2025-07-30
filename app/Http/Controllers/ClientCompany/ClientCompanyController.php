<?php

namespace App\Http\Controllers\ClientCompany;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\ClientCompany;
use App\Models\Client;
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

        $status = $request->input('status');

        $columns = array(
            0 => 'company_prefix',
            1 => 'name',
            2 => 'address',
            3 => 'phone',
            4 => 'status',
            5 => 'id',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $columns[$orderColumnIndex];
        $orderDirection = $request->input('order.0.dir');

        $query = ClientCompany::select('client_companies.*')
            ->where('status', 1)
            ->orderBy($orderColumnName, $orderDirection);

        if ($status != "all") {
            $query->where('client_companies.status', $status);
        }

        // Get total records count
        $totalData = $query->count();

        $searchValue = trim(strtolower($request->input('search.value')));

        if (!empty($searchValue)) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('client_companies.company_prefix', 'LIKE', "%{$searchValue}%")
                    ->orWhere('client_companies.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('client_companies.address', 'LIKE', "%{$searchValue}%")
                    ->orWhere('client_companies.phone', 'LIKE', "%{$searchValue}%");
            });
        }

        // Get total filtered records count
        $totalFiltered = $query->count();

        // Apply pagination
        $filteredData = $query->skip($start)->take($limit)->get();

        $data = array();

        foreach ($filteredData as $d) {

            $nestedData = array(
                'company_prefix'    => $d->company_prefix,
                'name'              => $d->name,
                'address'           => $d->address,
                'phone'             => $d->phone,
                'status'            => $d->status,
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
        $prefix         = $request->prefix;
        $name           = $request->name;
        $address        = $request->address;
        $companyPhone   = $request->companyPhone;
        $pics           = $request->pics;       // person-in-charge

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'prefix' => [
                    'required',
                    'string',
                    'max:4',
                    'unique:client_companies,company_prefix',
                    'regex:/^\S*$/', // No spaces allowed
                ],
                'name' => [
                    'required',
                    'string',
                    'unique:client_companies,name',
                    'max:255',
                ],
                'address' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'companyPhone' => [
                    'required',
                    'regex:/^\+?[0-9]+$/',
                    'max:255',
                ],
                'pics' => 'required|array|min:1',
                'pics.*.name' => 'required|string|max:255',
                'pics.*.email' => 'required|string|email|max:255',
                'pics.*.phone' => 'required|string|max:255',
                'pics.*.designation' => 'nullable|string|max:255',
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
            $company = ClientCompany::create([
                'company_prefix'    => $prefix,
                'name'              => $name,
                'address'           => $address,
                'phone'             => $companyPhone,
            ]);

            foreach ($pics as $pic) {
                Client::create([
                    'company_id'      => $company->id,
                    'name'            => $pic['name'],
                    'email'           => $pic['email'],
                    'phone'           => $pic['phone'],
                    'designation'     => $pic['designation'] ?? null,
                    'status'           => 1,
                ]);
            }

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
        $id                     = $request->id;
        $address                = $request->address;
        $phone                  = $request->companyPhone;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'prefix' => [
                    'required',
                    'string',
                    'max:4',
                    Rule::unique('client_companies', 'company_prefix')->ignore($id), // Exclude original value but still checks for uniqueness
                    'regex:/^\S*$/', // No spaces allowed
                ],
                'name' => [
                    'required',
                    'string',
                    Rule::unique('client_companies', 'name')->ignore($id), // Exclude original value but still checks for uniqueness
                    'max:255',
                ],
                'id' => [
                    'required',
                    'integer',
                    'exists:client_companies,id,status,1', // Ensure company status is 1 (active)
                ],
                'address' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'companyPhone' => [
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

                'id.exists' => 'The selected Client Company was deleted from the system!',

                'address.required' => 'The "Address" field is required.',
                'address.string' => 'The "Address" must be a string.',
                'address.max' => 'The "Address" must not be greater than :max characters.',

                'companyPhone.required' => 'The "Phone No." field is required.',
                'companyPhone.regex' => 'The "Phone No." field must only contain "+" symbol and numbers.',
                'companyPhone.max' => 'The "Phone No." field must not be greater than :max characters.',
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
            ClientCompany::where('id', $id)
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

        $id = $request->id;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'id' => [
                    'required',
                    'integer',
                    'exists:client_companies,id',
                ],
            ],
            [
                'id.exists' => 'The client company cannot be found.',
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
            ClientCompany::where('id', $id)
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
