<?php

namespace App\Http\Controllers\Vendors;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\VendorCompany;
use App\Models\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class VendorsController extends Controller
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
        if (is_null($this->user) || !$this->user->can('vendor.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any vendor. Contact system admin for access !');
        }

        $vendorcompany = VendorCompany::all();
        return view('vendors.index', compact('vendorcompany'));
    }

    /**
     * Show the vendor list.
     */
    public function list(Request $request)
    {
        // Set the time zone to Dubai
        $today = Carbon::today('Asia/Dubai');

        $ustatus = $request->input('ustatus');
        $vcompany = $request->input('vcompany');

        $columns = array(
            0 => 'name',
            1 => 'contact',
            2 => 'company_name',
            3 => 'ustatus',
            4 => 'status',
            5 => 'id',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $columns[$orderColumnIndex];
        $orderDirection = $request->input('order.0.dir');

        $query = Vendor::leftJoin('vendor_company', 'vendor_company.id', '=', 'vendors.company_id')
            ->select('vendors.name', 'vendors.contact', 'vendor_company.name as company_name', 'vendors.user_id', 'vendors.status', 'vendors.id')
            ->where('vendors.status', '1')
            ->orderBy($orderColumnName, $orderDirection);

        if ($ustatus == "0") {
            $query->where('vendors.user_id', null);
        } elseif ($ustatus == "1"){
            $query->whereNotNull('vendors.user_id');
        };

        if ($vcompany != "") {
            $query->where('vendor_company.id', $vcompany);
        }

        // Get total records count
        $totalData = $query->count();

        $searchValue = trim(strtolower($request->input('search.value')));

        if (!empty($searchValue)) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('vendors.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('vendors.contact', 'LIKE', "%{$searchValue}%")
                    ->orWhere('vendor_company.name', 'LIKE', "%{$searchValue}%");
            });
        }

        // Get total filtered records count
        $totalFiltered = $query->count();

        // Apply pagination
        $filteredData = $query->skip($start)->take($limit)->get();

        $data = array();

        foreach ($filteredData as $d) {
            // $status = ($d->from_date <= $today && $d->to_date >= $today) ? 'Active' : 'Inactive';

            $nestedData = array(
                'name'              => $d->name,
                'contact'           => $d->contact,
                'company_name'      => $d->company_name,
                'ustatus'           => $d->user_id,
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

    // /**
    //  * Create vendor.
    //  */
    public function create(Request $request)
    {
        $name       = $request->name;
        $contact    = $request->contact;
        $company    = $request->company;


        Log::info($request);


        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'contact' => [
                    'required',
                    'regex:/^\+?[0-9]+$/',
                    'max:255',
                ],
                'company' => [
                    'required',
                ],
            ],
            [
                'name.required' => 'The "Vendor Name" field is required.',
                'name.string' => 'The "Vendor Name" must be a string.',
                'name.max' => 'The "Vendor Name" must not be greater than :max characters.',

                'contact.required' => 'The "Contact No." field is required.',
                'contact.regex' => 'The "Contact No." field must only contain "+" symbol and numbers.',
                'contact.max' => 'The "Contact No." must not be greater than :max characters.',

                'company.required' => 'The "Vendor Company" field is required.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Insert new vendor
            $vendor = Vendor::create([
                'name'              => $name,
                'contact'           => $contact,
                'company_id'        => $company,
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

    // /**
    //  * Edit vendor.
    //  */
    public function edit(Request $request)
    {
        $id         = $request->original_vendor_id;
        $name       = $request->name;
        $contact    = $request->contact;


        Log::info($request);


        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'contact' => [
                    'required',
                    'regex:/^\+?[0-9]+$/',
                    'max:255',
                ],
            ],
            [
                'name.required' => 'The "Vendor Name" field is required.',
                'name.string' => 'The "Vendor Name" must be a string.',
                'name.max' => 'The "Vendor Name" must not be greater than :max characters.',

                'contact.required' => 'The "Contact No." field is required.',
                'contact.regex' => 'The "Contact No." field must only contain "+" symbol and numbers.',
                'contact.max' => 'The "Contact No." must not be greater than :max characters.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Update Vendor
            Vendor::where('id', $id)
                ->update([
                    'name'              => $name,
                    'contact'           => $contact,
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
     * Delete vendor.
     */
    public function delete(Request $request)
    {
        // Get the current UTC time
        $current_UTC = Carbon::now('UTC');

        $delete_vendor_id = $request->delete_vendor_id;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'delete_vendor_id' => [
                    'required',
                    'integer',
                    'exists:vendors,id',
                ],
            ],
            [
                'delete_vendor_id.exists' => 'The vendor cannot be found.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Select user id from client
            $vendor = Vendor::select('user_id')->where('id', $delete_vendor_id)->first();

            // Update stus to 0 as deleted (soft delete)
            Vendor::where('id', $delete_vendor_id)
                ->update([
                    'user_id'       => NULL,
                    'status'        => '0',
                    'deleted_at'    => $current_UTC
                ]);

                // Delete user related to vendor
            if ($vendor->user_id != ""){
                User::find($vendor->user_id)->delete();
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
}