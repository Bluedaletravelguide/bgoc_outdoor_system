<?php

namespace App\Http\Controllers\Suppliers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
// use App\Models\VendorCompany;
use App\Models\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class SuppliersController extends Controller
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
     * Show the supplier page.
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('suppliers.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any supplier. Contact system admin for access !');
        }

        $suppliername = Supplier::all();
        return view('suppliers.index', compact('suppliername'));
    }

    /**
     * Show the supplier list.
     */
    public function list(Request $request)
    {
        // Set the time zone to Dubai
        $today = Carbon::today('Asia/Dubai');

        // $ustatus = $request->input('ustatus');
        $suppliername = $request->input('suppliername');

        $columns = array(
            0 => 'code',
            1 => 'name',
            2 => 'address',
            3 => 'contact_person',
            4 => 'phone',
            5 => 'fax',
            6 => 'email',
            7 => 'description',
            8 => 'id',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $columns[$orderColumnIndex];
        $orderDirection = $request->input('order.0.dir');

        $query = Supplier::select('suppliers.id', 'suppliers.code', 'suppliers.name', 'suppliers.address', 'suppliers.contact_person',
            'suppliers.phone', 'suppliers.fax', 'suppliers.email', 'suppliers.description')
            ->orderBy($orderColumnName, $orderDirection);

        // Get total records count
        $totalData = $query->count();

        $searchValue = trim(strtolower($request->input('search.value')));

        if (!empty($searchValue)) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('suppliers.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('suppliers.contact_person', 'LIKE', "%{$searchValue}%")
                    ->orWhere('suppliers.code', 'LIKE', "%{$searchValue}%")
                    ->orWhere('suppliers.address', 'LIKE', "%{$searchValue}%");
            });
        }

        if ($suppliername != "") {
            $query->where('suppliers.id', $suppliername);
        }

        // Get total filtered records count
        $totalFiltered = $query->count();

        // Apply pagination
        $filteredData = $query->skip($start)->take($limit)->get();

        $data = array();

        foreach ($filteredData as $d) {
            // $status = ($d->from_date <= $today && $d->to_date >= $today) ? 'Active' : 'Inactive';

            $nestedData = array(
                'code'              => $d->code,
                'name'              => $d->name,
                'address'           => $d->address,
                'contact_person'    => $d->contact_person,
                'phone'             => $d->phone,
                'fax'               => $d->fax,
                'email'             => $d->email,
                'description'       => $d->description,
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
     * Create supplier.
     */
    public function create(Request $request)
    {
        $code               = $request->code;
        $name               = $request->name;
        $address            = $request->address;
        $contact_person     = $request->contact_person;
        $phone              = $request->phone;
        $fax                = $request->fax;
        $email              = $request->email;
        $description        = $request->description;


        Log::info($request);


        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'code' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:suppliers',
                ],
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'address' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'contact_person' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'phone' => [
                    'required',
                    'regex:/^\+?[0-9]+$/',
                    'max:255',
                ],
                'fax' => [
                ],
                'email' => [
                    'required',
                ],
                'description' => [
                ],
            ],
            [
                'code.required' => 'The "Supplier Code" field is required.',
                'code.string' => 'The "Supplier Code" must be a string.',
                'code.max' => 'The "Supplier Code" must not be greater than :max characters.',
                'code.unique' => 'The "Supplier Code" has already been taken.',

                'name.required' => 'The "Supplier Name" field is required.',
                'name.string' => 'The "Supplier Name" must be a string.',
                'name.max' => 'The "Supplier Name" must not be greater than :max characters.',

                'address.required' => 'The "Address" field is required.',
                'address.string' => 'The "Address" must be a string.',

                'contact_person.required' => 'The "Contact Person" field is required.',
                'contact_person.string' => 'The "Contact Person" must be a string.',

                'phone.required' => 'The "Phone No." field is required.',
                'phone.regex' => 'The "Phone No." field must only contain "+" symbol and numbers.',
                'phone.max' => 'The "Phone No." must not be greater than :max characters.',

                'email.required' => 'The " Email" field is required.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Insert new supplier
            $supplier = Supplier::create([
                'code'              => $code,
                'name'              => $name,
                'address'           => $address,
                'contact_person'    => $contact_person,
                'phone'             => $phone,
                'fax'               => $fax,
                'email'             => $email,
                'description'       => $description,
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
    //  * Edit supplier.
    //  */
    public function edit(Request $request)
    {
        $id                 = $request->original_supplier_id;
        $name               = $request->name;
        $address            = $request->address;
        $contact_person     = $request->contact_person;
        $phone              = $request->phone;
        $fax                = $request->fax;
        $email              = $request->email;
        $description        = $request->description;


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
                'address' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'contact_person' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'phone' => [
                    'required',
                    'regex:/^\+?[0-9]+$/',
                    'max:255',
                ],
                'fax' => [
                ],
                'email' => [
                    'required',
                ],
                'description' => [
                ],
            ],
            [
                'name.required' => 'The "Supplier Name" field is required.',
                'name.string' => 'The "Supplier Name" must be a string.',
                'name.max' => 'The "Supplier Name" must not be greater than :max characters.',

                'address.required' => 'The "Address" field is required.',
                'address.string' => 'The "Address" must be a string.',

                'contact_person.required' => 'The "Contact Person" field is required.',
                'contact_person.string' => 'The "Contact Person" must be a string.',

                'phone.required' => 'The "Phone No." field is required.',
                'phone.regex' => 'The "Phone No." field must only contain "+" symbol and numbers.',
                'phone.max' => 'The "Phone No." must not be greater than :max characters.',

                'email.required' => 'The "Email" field is required.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Update Supplier
            Supplier::where('id', $id)
                ->update([
                    'name'            => $name,
                    'address'         => $address,
                    'contact_person'  => $contact_person,
                    'phone'           => $phone,
                    'fax'             => $fax,
                    'email'           => $email,
                    'description'     => $description,
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
     * Delete supplier.
     */
    public function delete(Request $request)
    {
        // Get the current UTC time
        $current_UTC = Carbon::now('UTC');

        $delete_supplier_id = $request->delete_supplier_id;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'delete_supplier_id' => [
                    'unique:purchase_orders,supplier_id',
                ],
            ],
            [
                'delete_supplier_id.unique' => 'This cannot be deleted as purchase order is found associated with this supplier',
            ]
        );

        logger($validator->errors());

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            Supplier::find($delete_supplier_id)->delete();
            
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