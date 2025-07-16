<?php

namespace App\Http\Controllers\PurchaseOrder;

use App\Models\Asset;
use App\Models\Employee;
use App\Models\Supplier;
use App\Models\User;
use App\Models\VendorCompany;
use App\Models\Vendor;
use App\Models\PurchaseOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class PurchaseOrderController extends Controller
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
     * Show the purchase order dashboard.
     *
     */
    public function index()
    {   
        if (is_null($this->user) || !$this->user->can('asset.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any purchased order. Please contact system admin for access !');
        }

        $suppliers = Supplier::all();

        return view('purchaseOrder.index', compact('suppliers'));
    }

    /**
     * Show the purchase order list.
     */
    public function list(Request $request)
    {
        $supplier_id_filter     = $request->input('supplierId');
        $warranty_status_filter = strtoupper($request->input('warrantyStatus'));

        $columns = array(
            0 => 'id',
            1 => 'receipt_reference_number',
            2 => 'price',
            3 => 'purchase_date',
            4 => 'warranty_from',
            5 => 'warranty_until',
            7 => 'description',
        );

        $limit = $request->input('length');
        $start = $request->input('start');

        $orderColumnIndex   = $request->input('order.0.column');
        $orderColumnName    = $columns[$orderColumnIndex];
        $orderDirection     = $request->input('order.0.dir');

        $query = PurchaseOrder::select('*') 
            -> orderBy($orderColumnName, $orderDirection)
        ;

        //Filter purchase order by supplier id
        if($supplier_id_filter != 'all') {
            $query->where('supplier_id', $supplier_id_filter);
        }

        // Get total records count
        $totalData = $query->get()->count(); 
        
        $searchValue = trim(strtolower($request->input('search.value')));

        if (!empty($searchValue)) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('receipt_reference_number', 'LIKE', "%{$searchValue}%")
                    ->orWhere('price', 'LIKE', "%{$searchValue}%")
                    ->orWhere('description', 'LIKE', "%{$searchValue}%")
                ;
            });
        };

        // Get total filtered records count
        $totalFiltered = $query->get()->count();

        // Apply pagination
        $filteredData = $query->skip($start)->take($limit)->get();

        $data = array();

        foreach ($filteredData as $d) {
            // Date variables
            $purchase_date  = Carbon::parse($d->purchase_date)->format('d M, Y');
            $warranty_from  = Carbon::parse($d->warranty_from)->format('d M, Y');
            $warranty_until = Carbon::parse($d->warranty_until)->format('d M, Y');
            $dateNow        = Carbon::now()->toDateString();

            //Validate if the warranty is valid or expiered
            if(Carbon::parse($dateNow)->greaterThan($d->warranty_until)) {
                $warranty_status = 'EXPIRED' ;
            } else {
                $warranty_status = 'VALID' ;
            }

            //Filter purchase order by warranty status
            if($warranty_status_filter == 'ALL' || $warranty_status_filter == $warranty_status) {
                $nestedData = array(  
                    'receipt_reference_number'  => $d->receipt_reference_number,
                    'price'                     => $d->price,
                    'purchase_date'             => $purchase_date,
                    'warranty_from'             => $warranty_from,
                    'warranty_until'            => $warranty_until,
                    'warranty_status'           => $warranty_status,
                    'description'               => $d->description,
                    "supplier_id"               => $d->supplier_id,
                    'id'                        => $d->id,
                );

                $data[] = $nestedData;
            }
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
     * Create new purchase order.
     */
    public function create(Request $request)
    {   
        $receipt_reference_number   = $request->receipt_reference_number ;
        $price                      = $request->price ;
        $originalPurchase_date      = $request->purchase_date ;
        $warranty                   = $request->warranty ;
        $supplier_id                = $request->supplier_id ;
        $description                = $request->description ;
        
        //Adjust the datetime format for purchase_date and warranty
        $originalDateFormat = 'd M, Y' ;

        $purchase_date  = Carbon::createFromFormat($originalDateFormat, $originalPurchase_date)->format('Y-m-d');
        $warranty_from  = Carbon::createFromFormat($originalDateFormat, explode(' - ', $warranty)[0])->format('Y-m-d');
        $warranty_until = Carbon::createFromFormat($originalDateFormat, explode(' - ', $warranty)[1])->format('Y-m-d');

        // Validate fields
        $validator = Validator::make(
            [
                'receipt_reference_number'  => $receipt_reference_number,
                'price_num'                 => $price,
                'price_str'                 => $price,
                'purchase_date'             => $purchase_date,
                'warranty_from'             => $warranty_from,
                'warranty_until'            => $warranty_until,
                'supplier_id'               => $supplier_id,      
                'description'               => $description,
            ],
            [
                'receipt_reference_number' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:purchase_orders,receipt_reference_number',
                    'regex:/^[^A-Za-z0-9]*[A-Za-z0-9].*$/', //Ensure the fields not only contains special character
                ],
                'price_num' => [
                    'required',
                    'numeric',
                    'decimal:0,4'
                ],
                'price_str' => [
                    'required',
                    'max:10',
                ],
                'purchase_date' => [
                    'required',
                    'date',
                ],
                'warranty_from' => [
                    'required',
                    'date',
                ],
                'warranty_until' => [
                    'required',
                    'date',
                    'after_or_equal:warranty_from',
                ],
                'supplier_id' => [
                    'required',
                    'exists:suppliers,id',
                ],
                'description' => [
                    'nullable',
                    'string',
                    'max:255',
                    'regex:/^[^A-Za-z0-9]*[A-Za-z0-9].*$/', //Ensure the fields not only contains special character
                ],
            ],
            [
                'receipt_reference_number.required' => 'The "Receipt Reference Number" field is required.',
                'receipt_reference_number.string'   => 'The "Receipt Reference Number" must be a string.',
                'receipt_reference_number.max'      => 'The "Receipt Reference Number" must not be greater than :max characters.',
                'receipt_reference_number.unique'   => 'The "Receipt Reference Number" is already been taken.',
                'receipt_reference_number.regex'    => 'The "Receipt Reference Number" field must contain alphanumeric.',
        
                'price_num.required'    => 'The "Price" field is required.',
                'price_num.numeric'     => 'The "Price" must be a numeric.',
                'price_num.decimal'     => 'The "Price" field must only have 0-4 decimal places.',

                'price_str.max'         => 'The "Price" must not be greater than :max characters.',

                'purchase_date.required'   => 'The "Purchase Date" field is required.',
                'purchase_date.date'       => 'The "Purchase Date" field must be a date format',
        
                'warranty_from.required' => 'The "Warranty" field is required.',
                'warranty_from.date'     => 'The "Warranty" must be a date format.',

                'warranty_until.required'          => 'The "Warranty" field is required.',
                'warranty_until.date'              => 'The "Warranty" must be a date format.',
                'warranty_until.after_or_equal'    => 'The "Warranty" range is incorrect.',

                'supplier_id.required'  => 'The "Supplier" field is required.',
                'supplier_id.exists'    => 'This supplier is not occur.',

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
            $purchaseOrder = PurchaseOrder::create([
                'receipt_reference_number'  => $receipt_reference_number,
                'price'                     => $price,
                'purchase_date'             => $purchase_date,
                'warranty_from'             => $warranty_from,
                'warranty_until'            => $warranty_until,
                'description'               => $description,
                'supplier_id'               => $supplier_id,
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

        return response()->json([
            "success"   => $request->warranty,
        ], 200);
    }

    /**
     * Edit purchase order.
     */
    public function edit(Request $request)
    {   
        $original_purchaseOrder_id  = $request->original_purchaseOrder_id ;
        $receipt_reference_number   = $request->receipt_reference_number ;
        $price                      = $request->price ;
        $originalPurchase_date      = $request->purchase_date ;
        $warranty                   = $request->warranty ;
        $supplier_id                = $request->supplier_id ;
        $description                = $request->description ;

        //Adjust the datetime format for purchase_date and warranty
        $originalDateFormat = 'd M, Y' ;

        $purchase_date  = Carbon::createFromFormat($originalDateFormat, $originalPurchase_date)->format('Y-m-d');
        $warranty_from  = Carbon::createFromFormat($originalDateFormat, explode(' - ', $warranty)[0])->format('Y-m-d');
        $warranty_until = Carbon::createFromFormat($originalDateFormat, explode(' - ', $warranty)[1])->format('Y-m-d');

        // Validate fields
        $validator = Validator::make(
            [
                'original_purchaseOrder_id' => $original_purchaseOrder_id,
                'receipt_reference_number'  => $receipt_reference_number,
                'price_num'                 => $price,
                'price_str'                 => $price,
                'purchase_date'             => $purchase_date,
                'warranty_from'             => $warranty_from,
                'warranty_until'            => $warranty_until,
                'supplier_id'               => $supplier_id,      
                'description'               => $description,
            ],
            [
                'original_purchaseOrder_id' => [
                    'required',
                    'integer',
                    'max:255',
                    'exists:purchase_orders,id', // Ensure purchase order is exists
                ],
                'receipt_reference_number' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('purchase_orders', 'receipt_reference_number')->ignore($receipt_reference_number,'receipt_reference_number'),  //Exclude original value but still checks for uniqueness
                    'regex:/^[^A-Za-z0-9]*[A-Za-z0-9].*$/', //Ensure the fields not only contains special character
                ],
                'price_num' => [
                    'required',
                    'numeric',
                    'decimal:0,4'
                ],
                'price_str' => [
                    'required',
                    'max:10',
                ],
                'purchase_date' => [
                    'required',
                    'date',
                ],
                'warranty_from' => [
                    'required',
                    'date',
                ],
                'warranty_until' => [
                    'required',
                    'date',
                    'after_or_equal:warranty_from',
                ],
                'supplier_id' => [
                    'required',
                    'exists:suppliers,id',
                ],
                'description' => [
                    'nullable',
                    'string',
                    'max:255',
                    'regex:/^[^A-Za-z0-9]*[A-Za-z0-9].*$/', //Ensure the fields not only contains special character
                ],
            ],
            [
                'original_purchaseOrder_id.exists' => 'This purchase order cannot be found.',

                'receipt_reference_number.required' => 'The "Receipt Reference Number" field is required.',
                'receipt_reference_number.string'   => 'The "Receipt Reference Number" must be a string.',
                'receipt_reference_number.max'      => 'The "Receipt Reference Number" must not be greater than :max characters.',
                'receipt_reference_number.unique'   => 'The "Receipt Reference Number" is already been taken.',
                'receipt_reference_number.regex'    => 'The "Receipt Reference Number" field must contain alphanumeric.',
        
                'price_num.required'    => 'The "Price" field is required.',
                'price_num.numeric'     => 'The "Price" must be a numeric.',
                'price_num.decimal'     => 'The "Price" field must only have 0-4 decimal places.',

                'price_str.max'         => 'The "Price" must not be greater than :max characters.',

                'purchase_date.required'   => 'The "Purchase Date" field is required.',
                'purchase_date.date'       => 'The "Purchase Date" field must be a date format',
        
                'warranty_from.required' => 'The "Warranty" field is required.',
                'warranty_from.date'     => 'The "Warranty" must be a date format.',

                'warranty_until.required'          => 'The "Warranty" field is required.',
                'warranty_until.date'              => 'The "Warranty" must be a date format.',
                'warranty_until.after_or_equal'    => 'The "Warranty" range is incorrect.',

                'supplier_id.required'  => 'The "Supplier" field is required.',
                'supplier_id.exists'    => 'This supplier is not occur.',

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

            // Update purchase order details
            PurchaseOrder::where('purchase_orders.id', $original_purchaseOrder_id)
                ->update([
                    'receipt_reference_number'  => $receipt_reference_number,
                    'price'                     => $price,
                    'purchase_date'             => $purchase_date,
                    'warranty_from'             => $warranty_from,
                    'warranty_until'            => $warranty_until,
                    'supplier_id'               => $supplier_id,
                    'description'               => $description,
                ])
            ;

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
     * Delete purchase order.
     */
    public function delete(Request $request)
    {   
        $delete_purchaseOrder_id = $request->delete_purchaseOrder_id ;

        //Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'delete_purchaseOrder_id' => [
                    'required',
                    'integer',
                    'exists:purchase_orders,id',
                    'unique:assets,purchase_order_id',             //Validate the purchase order to be deleted is not association to any exsisting assets data
                ],
            ],
            [
                'delete_purchaseOrder_id.exists' => 'This purchase order cannot be found.',
                'delete_purchaseOrder_id.unique' => 'This cannot be deleted as service request is found associated with this purchase order.'
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        };

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Delete the purchase order
            PurchaseOrder::where('id', $delete_purchaseOrder_id)->delete();

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