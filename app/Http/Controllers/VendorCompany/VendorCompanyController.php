<?php

namespace App\Http\Controllers\VendorCompany;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\VendorCompany;
use App\Models\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
//use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VendorCompanyController extends Controller
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
     * Show the vendor company dashboard.
     *
     */
    public function Index()
    {   
        if (is_null($this->user) || !$this->user->can('vendor.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any vendor. Contact system admin for access !');
        }

        return view('vendorCompany.index');
    }

    /**
     * Show the vendor company list.
     */
    public function list(Request $request)
    {
        $columns = array(
            0 => 'name',
            1 => 'services_offered',
            2 => 'phone',
            3 => 'address',
            4 => 'number_of_employee',
            5 => 'description',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $columns[$orderColumnIndex];
        $orderDirection = $request->input('order.0.dir');

        $query = VendorCompany::leftJoin('vendors','vendor_company.id', '=', 'vendors.company_id')
            ->select('vendor_company.*')
            ->where('vendor_company.status', '1')
            ->groupBy('vendor_company.id')
            ->orderBy($orderColumnName, $orderDirection);

        // Get total records count
        $totalData = $query->get()->count(); 
        
        $searchValue = trim(strtolower($request->input('search.value')));

        if (!empty($searchValue)) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('vendor_company.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('vendor_company.services_offered', 'LIKE', "%{$searchValue}%")
                    ->orWhere('vendor_company.phone', 'LIKE', "%{$searchValue}%")
                    ->orWhere('vendor_company.address', 'LIKE', "%{$searchValue}%");
            });
        };

        // Get total filtered records count
        $totalFiltered = $query->get()->count();

        // Apply pagination
        $filteredData = $query->skip($start)->take($limit)->get();

        $data = array();

        foreach ($filteredData as $d) {

            $vendor_count = Vendor::where('status', '1')
                ->where('company_id', $d->id)
                ->count();
            
            $nestedData = array(
                'name'                  => $d->name,
                'services_offered'      => $d->services_offered,
                'phone'                 => $d->phone,
                'address'               => $d->address,
                'number_of_employee'    => $vendor_count,
                'description'           => $d->description,
                'id'                    => $d->id,
            );

            $data[] = $nestedData;
        };

        $json_data = array(
            "draw"              => intval($request->input('draw')),
            "recordsTotal"      => intval($totalData),
            "recordsFiltered"   => intval($totalFiltered),
            "data"              => $data,
        );

        echo json_encode($json_data);
    }

    /**
     * Create vendor company.
     */
    public function Create(Request $request)
    {
        $name               = $request->name;
        $services_offered   = $request->services_offered;
        $phone              = $request->phone;
        $address            = $request->address;
        $description        = $request->description;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:vendor_company,name',
                    'regex:/^[^A-Za-z0-9]*[A-Za-z0-9].*$/', //Ensure the fields not only contains special character
                ],
                'services_offered' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[^A-Za-z0-9]*[A-Za-z0-9].*$/', //Ensure the fields not only contains special character
                ],
                'phone' => [
                    'required',
                    'regex:/^\+?[0-9-()]+[^-()]$/',
                    'max:255',
                ],
                'address' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[^A-Za-z0-9]*[A-Za-z0-9].*$/', //Ensure the fields not only contains special character
                ],
                'description' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[^A-Za-z0-9]*[A-Za-z0-9].*$/', //Ensure the fields not only contains special character
                ],
            ],
            [
                'name.required' => 'The "Vendor Company Name" field is required.',
                'name.string'   => 'The "Vendor Company Name" must be a string.',
                'name.max'      => 'The "Vendor Company Name" must not be greater than :max characters.',
                'name.unique'   => 'The "Vendor Company Name" is already been taken.',
                'name.regex'    => 'The "Vendor Company Name" field must contain alphanumeric.',
        
                'services_offered.required' => 'The "Services Offered" field is required.',
                'services_offered.string'   => 'The "Services Offered" must be a string.',
                'services_offered.max'      => 'The "Services Offered" must not be greater than :max characters.',
                'services_offered.regex'    => 'The "Services Offered" field must contain alphanumeric.',

                'phone.required'    => 'The "Contact" field is required.',
                'phone.regex'       => 'The "Contact" field must only contain a "+" symbol with numbers and "()-" symbols.',
                'phone.max'         => 'The "Role" must not be greater than :max characters.',
        
                'address.required' => 'The "Address" field is required.',
                'address.string'   => 'The "Address" must be a string.',
                'address.max'      => 'The "Address" must not be greater than :max characters.',
                'address.regex'    => 'The "Address" field must contain alphanumeric.',

                'description.required' => 'The "Description" field is required.',
                'description.string'   => 'The "Description" must be a string.',
                'description.max'      => 'The "Description" must not be greater than :max characters.',
                'description.regex'    => 'The "Description" field must contain alphanumeric.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        };

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Insert new vendor company
            $vendorCompany = VendorCompany::create([
                'name'              => $name,
                'services_offered'  => $services_offered,
                'phone'             => $phone,
                'address'           => $address,
                'description'       => $description,
                'status'            => "1",
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
     * Edit vendor company.
     */
    public function Edit(Request $request)
    {
        $original_vendorCompany_name    = $request->original_vendorCompany_name;
        $name                           = $request->name;
        $services_offered               = $request->services_offered;
        $phone                          = $request->phone;
        $address                        = $request->address;
        $description                    = $request->description;

        //Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'original_vendorCompany_name' => [
                    'required',
                    'string',
                    'max:255',
                    'exists:vendor_company,name,status,1', // Ensure company status is 1 (active)
                ],
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('vendor_company', 'name')->ignore($original_vendorCompany_name,'name'),  //Exclude original value but still checks for uniqueness
                    'regex:/^[^A-Za-z0-9]*[A-Za-z0-9].*$/', //Ensure the fields not only contains special character
                ],
                'services_offered' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[^A-Za-z0-9]*[A-Za-z0-9].*$/', //Ensure the fields not only contains special character
                ],
                'phone' => [
                    'required',
                    'regex:/^\+?[0-9-()]+[^-()]$/',
                    'max:255',
                ],
                'address' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[^A-Za-z0-9]*[A-Za-z0-9].*$/', //Ensure the fields not only contains special character
                ],
                'description' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[^A-Za-z0-9]*[A-Za-z0-9].*$/', //Ensure the fields not only contains special character
                ],
            ],
            [
                'original_vendorCompany_name.exists'    => 'The selected Vendor Company was deleted from the system!',

                'name.required' => 'The "Vendor Company Name" field is required.',
                'name.string'   => 'The "Vendor Company Name" must be a string.',
                'name.max'      => 'The "Vendor Company Name" must not be greater than :max characters.',
                'name.unique'   => 'The "Vendor Company Name" is already been taken.',
                'name.regex'    => 'The "Vendor Company Name" field must contain alphanumeric.',
        
                'services_offered.required' => 'The "Services Offered" field is required.',
                'services_offered.string'   => 'The "Services Offered" must be a string.',
                'services_offered.max'      => 'The "Services Offered" must not be greater than :max characters.',
                'services_offered.regex'    => 'The "Services Offered" field must contain alphanumeric.',

                'phone.required'    => 'The "Contact" field is required.',
                'phone.regex'       => 'The "Contact" field must only contain a "+" symbol with numbers and "()-" symbols.',
                'phone.max'         => 'The "Contact" must not be greater than :max characters.',
        
                'address.required' => 'The "Address" field is required.',
                'address.string'   => 'The "Address" must be a string.',
                'address.max'      => 'The "Address" must not be greater than :max characters.',
                'address.regex'    => 'The "Address" field must contain alphanumeric.',

                'description.required' => 'The "Description" field is required.',
                'description.string'   => 'The "Description" must be a string.',
                'description.max'      => 'The "Description" must not be greater than :max characters.',
                'description.regex'    => 'The "Description" field must contain alphanumeric.',
            ]
        );
        
        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        };

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            $vendorCompany = VendorCompany::leftJoin('vendors','vendor_company.id', '=', 'vendors.company_id')
                ->select(DB::raw('vendor_company.*, count(vendors.id) as number_of_employee'))
                ->where('vendor_company.status', '1')
                ->where('vendor_company.name', $original_vendorCompany_name)
                ->groupBy('vendor_company.id')
                ->first();

            // Handle the case where the vendor company is not found
            if (!$vendorCompany) {
                return response()->json(['error' => 'Vendor company not found.'], 404);
            }

            // Update vendor company details
            VendorCompany::where('vendor_company.name', $original_vendorCompany_name)
                ->update([
                    'name'              => $name,
                    'services_offered'  => $services_offered,
                    'phone'             => $phone,
                    'address'           => $address,
                    'description'       => $description
                ]);

            // Ensure all queries successfully executed, commit the db changes
            DB::commit();

            return response()->json([
                "name"                  => $vendorCompany->name,
                "services_offered"      => $vendorCompany->services_offered,
                "phone"                 => $vendorCompany->phone,
                "address"               => $vendorCompany->address,
                "number_of_employee"    => $vendorCompany->number_of_employee,
                "description"           => $vendorCompany->description,
            ], 200);
        } catch (\Exception $e) {
            // If any queries fail, undo all changes
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
    
    /**
     * Delete vendor company.
     */
    public function Delete(Request $request)
    {   
        $delete_vendorCompany_id = $request->delete_vendorCompany_id;
        
        //Get current UTC time
        $current_UTC = Carbon::now('UTC');

        //Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'delete_vendorCompany_id' => [
                    'required',
                    'integer',
                    'exists:vendor_company,id',
                ],
            ],
            [
                'delete_vendorCompany_id.exists' => 'The vendor company cannot be found.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        };

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Update vendor company status to 0 as deleted (soft delete)
            VendorCompany::where('id', $delete_vendorCompany_id)
                ->update([
                    'status'        => '0',
                    'deleted_at'    =>  $current_UTC
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
        };
    }

}