<?php

namespace App\Http\Controllers\StockInventory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Billboard;
use App\Models\Client;
use App\Models\ClientCompany;
use App\Models\Contractor;
use App\Models\StockInventory;
use App\Models\StockInventoryTransaction;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class StockInventoryController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('client.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any client. Contact system admin for access !');
        }

        // Get clients data
        $clients = Client::leftJoin('client_companies', 'client_companies.id', '=', 'clients.company_id')
        ->select('clients.*', 'client_companies.name as company_name')
        ->where('clients.status', '=', '1')
        ->get();
        
        // Get user data
        $users = User::where('id', '!=', auth()->id())->get();
        
        // Get client company data
        $clientcompany = ClientCompany::all();

        // Get contractor data
        $contractors = Contractor::all();

        // Get billboard data
        $billboards = Billboard::leftJoin('locations', 'billboards.location_id', '=', 'locations.id')->get();

        return view('stockInventory.index', compact('clients', 'users', 'clientcompany',  'contractors', 'billboards'));
    }

    /**
     * Show the contractor users list.
     */
    // public function list(Request $request)
    // {
    //     $columns = [
    //         0  => 'contractors.name',
    //         1  => 'billboards.site_number',
    //         2  => 'billboards.type',
    //         3  => 'billboards.size',
    //         4  => 'stock_inventories.balance_contractor',
    //         5  => 'stock_inventories.balance_bgoc',
    //         6  => 'transactions_in.remarks',
    //         7  => 'transactions_in.quantity',
    //         8  => 'transactions_in.transaction_date',
    //         9  => 'transactions_out.remarks',
    //         10 => 'transactions_out.quantity',
    //         11 => 'transactions_out.transaction_date',
    //         12 => 'contractors.company_name',
    //         13 => 'transactions_in.id',
    //         14 => 'transactions_out.id',
    //     ];

    //     $limit = $request->input('length');
    //     $start = $request->input('start');
    //     $orderColumnIndex = $request->input('order.0.column');
    //     $orderColumnName = $columns[$orderColumnIndex] ?? 'stock_inventories.id';
    //     $orderDirection = $request->input('order.0.dir', 'asc');

    //     // Base query with joins
    //     $query = StockInventory::select(
    //             'stock_inventories.*',

    //             // IN transactions
    //             'transactions_in.id as transaction_in_id',
    //             'transactions_in.quantity as quantity_in',
    //             'transactions_in.transaction_date as date_in',
    //             'transactions_in.remarks as remarks_in',
    //             'billboard_in.site_number as billboard_in_site',
    //             'billboard_in.type as billboard_in_type',
    //             'billboard_in.size as billboard_in_size',
    //             'client_in.name as client_in_name',
    //             'site_in.name as site_in',

    //             // OUT transactions
    //             'transactions_out.id as transaction_out_id',
    //             'transactions_out.quantity as quantity_out',
    //             'transactions_out.transaction_date as date_out',
    //             'transactions_out.remarks as remarks_out',
    //             'billboard_out.site_number as billboard_out_site',
    //             'billboard_out.size as billboard_out_size',
    //             'client_out.name as client_out_name',
    //             'site_out.name as site_out',

    //             // Contractor
    //             'contractors.company_name as contractor_company',
    //             'contractors.name as contractor_name',
    //             'contractors.phone as contractor_phone'
    //         )
    //         // IN transactions
    //         ->leftJoin('stock_inventory_transactions as transactions_in', function($join) {
    //             $join->on('transactions_in.stock_inventory_id', '=', 'stock_inventories.id')
    //                 ->where('transactions_in.type', '=', 'in');
    //         })
    //         ->leftJoin('billboards as billboard_in', 'billboard_in.id', '=', 'transactions_in.billboard_id')
    //         ->leftJoin('locations as site_in', 'site_in.id', '=', 'transactions_in.billboard_id')
    //         ->leftJoin('client_companies as client_in', 'client_in.id', '=', 'transactions_in.client_id')

    //         // OUT transactions
    //         ->leftJoin('stock_inventory_transactions as transactions_out', function($join) {
    //             $join->on('transactions_out.stock_inventory_id', '=', 'stock_inventories.id')
    //                 ->where('transactions_out.type', '=', 'out');
    //         })
    //         ->leftJoin('billboards as billboard_out', 'billboard_out.id', '=', 'transactions_out.billboard_id')
    //         ->leftJoin('locations as site_out', 'site_out.id', '=', 'transactions_out.billboard_id')
    //         ->leftJoin('client_companies as client_out', 'client_out.id', '=', 'transactions_out.client_id')

    //         // Contractor
    //         ->leftJoin('contractors', 'contractors.id', '=', 'stock_inventories.contractor_id')
    //         ->orderBy($orderColumnName, $orderDirection);

    //     $totalData = $query->count();

    //     // Search filter
    //     $searchValue = trim($request->input('search.value'));
    //     if (!empty($searchValue)) {
    //         $query->where(function ($q) use ($searchValue) {
    //             $q->where('client_in.name', 'LIKE', "%{$searchValue}%")
    //             ->orWhere('client_out.name', 'LIKE', "%{$searchValue}%")
    //             ->orWhere('billboard_in.site_number', 'LIKE', "%{$searchValue}%")
    //             ->orWhere('billboard_in.type', 'LIKE', "%{$searchValue}%")
    //             ->orWhere('billboard_in.size', 'LIKE', "%{$searchValue}%")
    //             ->orWhere('billboard_out.site_number', 'LIKE', "%{$searchValue}%")
    //             ->orWhere('transactions_in.remarks', 'LIKE', "%{$searchValue}%")
    //             ->orWhere('transactions_out.remarks', 'LIKE', "%{$searchValue}%")
    //             ->orWhere('contractors.company_name', 'LIKE', "%{$searchValue}%")
    //             ->orWhere('contractors.name', 'LIKE', "%{$searchValue}%")
    //             ->orWhere('contractors.phone', 'LIKE', "%{$searchValue}%");
    //         });
    //     }

    //     $totalFiltered = $query->count();

    //     $filteredData = $query->skip($start)->take($limit)->get();

    //     $data = [];
    //     foreach ($filteredData as $d) {
    //         $data[] = [
    //             'client_in_name'     => $d->client_in_name,
    //             'billboard_in_site'  => $d->billboard_in_site,
    //             'site_in'            => $d->site_in,
    //             'billboard_in_type'  => $d->billboard_in_type,
    //             'billboard_in_size'  => $d->billboard_in_size,
    //             'balance_contractor' => $d->balance_contractor,
    //             'balance_bgoc'       => $d->balance_bgoc,
    //             'remarks_in'         => $d->remarks_in,
    //             'quantity_in'        => $d->quantity_in,
    //             'date_in'            => $d->date_in ? Carbon::parse($d->date_in)->format('d/m/y') : null,
    //             'transaction_in_id'  => $d->transaction_in_id,

    //             'client_out_name'    => $d->client_out_name,
    //             'billboard_out_site' => $d->billboard_out_site,
    //             'site_out'           => $d->site_out,
    //             'billboard_out_size' => $d->billboard_out_size,
    //             'remarks_out'        => $d->remarks_out,
    //             'quantity_out'       => $d->quantity_out,
    //             'date_out'           => $d->date_out ? Carbon::parse($d->date_out)->format('d/m/y') : null,
    //             'transaction_out_id' => $d->transaction_out_id,

    //             'contractor'         => $d->contractor_company . ' (' . $d->contractor_name . ')',
    //             'contractor_phone'   => $d->contractor_phone,
    //             'stock_inventory_id' => $d->id, // keep original stock inventory id if needed
    //         ];
    //     }

    //     logger('data: ' , $data);

    //     return response()->json([
    //         "draw"            => intval($request->input('draw')),
    //         "recordsTotal"    => intval($totalData),
    //         "recordsFiltered" => intval($totalFiltered),
    //         "data"            => $data,
    //     ]);
    // }

    public function list(Request $request)
    {
        $columns = [
            0  => 'contractors.name',
            1  => 'billboards.site_number',
            2  => 'billboards.type',
            3  => 'billboards.size',
            4  => 'stock_inventories.balance_contractor',
            5  => 'stock_inventories.balance_bgoc',
            6  => 'transactions_in.remarks',
            7  => 'transactions_in.quantity',
            8  => 'transactions_in.transaction_date',
            9  => 'transactions_out.remarks',
            10 => 'transactions_out.quantity',
            11 => 'transactions_out.transaction_date',
            12 => 'contractors.company_name',
            13 => 'transactions_in.id',
            14 => 'transactions_out.id',
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $columns[$orderColumnIndex] ?? 'stock_inventories.id';
        $orderDirection = $request->input('order.0.dir', 'asc');

        // Base query with joins
        $query = StockInventory::select(
                'stock_inventories.*',

                // IN transactions
                'transactions_in.id as transaction_in_id',
                'transactions_in.quantity as quantity_in',
                'transactions_in.transaction_date as date_in',
                'transactions_in.remarks as remarks_in',
                'transactions_in.billboard_id as site_in_id', // ✅ Add site ID for IN
                'transactions_in.client_id as client_in_id',   // ✅ Add client ID for IN
                'billboard_in.site_number as billboard_in_site',
                'billboard_in.type as type_in',                // ✅ Rename to match frontend
                'billboard_in.size as size_in',                // ✅ Rename to match frontend
                'client_in.name as client_in_name',
                'site_in.name as site_in',

                // OUT transactions
                'transactions_out.id as transaction_out_id',
                'transactions_out.quantity as quantity_out',
                'transactions_out.transaction_date as date_out',
                'transactions_out.remarks as remarks_out',
                'transactions_out.billboard_id as site_out_id', // ✅ Add site ID for OUT
                'transactions_out.client_id as client_out_id',   // ✅ Add client ID for OUT
                'billboard_out.site_number as billboard_out_site',
                'billboard_out.type as type_out',                // ✅ Add type for OUT
                'billboard_out.size as size_out',                // ✅ Add size for OUT
                'client_out.name as client_out_name',
                'site_out.name as site_out',

                // Contractor
                'contractors.id as contractor_id',               // ✅ Add contractor ID
                'contractors.company_name as contractor_company',
                'contractors.name as contractor_name',
                'contractors.phone as contractor_phone'
            )
            // IN transactions
            ->leftJoin('stock_inventory_transactions as transactions_in', function($join) {
                $join->on('transactions_in.stock_inventory_id', '=', 'stock_inventories.id')
                    ->where('transactions_in.type', '=', 'in');
            })
            ->leftJoin('billboards as billboard_in', 'billboard_in.id', '=', 'transactions_in.billboard_id')
            ->leftJoin('locations as site_in', 'site_in.id', '=', 'transactions_in.billboard_id')
            ->leftJoin('client_companies as client_in', 'client_in.id', '=', 'transactions_in.client_id')

            // OUT transactions
            ->leftJoin('stock_inventory_transactions as transactions_out', function($join) {
                $join->on('transactions_out.stock_inventory_id', '=', 'stock_inventories.id')
                    ->where('transactions_out.type', '=', 'out');
            })
            ->leftJoin('billboards as billboard_out', 'billboard_out.id', '=', 'transactions_out.billboard_id')
            ->leftJoin('locations as site_out', 'site_out.id', '=', 'transactions_out.billboard_id')
            ->leftJoin('client_companies as client_out', 'client_out.id', '=', 'transactions_out.client_id')

            // Contractor
            ->leftJoin('contractors', 'contractors.id', '=', 'stock_inventories.contractor_id')
            ->orderBy($orderColumnName, $orderDirection);

        $totalData = $query->count();

        // Search filter
        $searchValue = trim($request->input('search.value'));
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('client_in.name', 'LIKE', "%{$searchValue}%")
                ->orWhere('client_out.name', 'LIKE', "%{$searchValue}%")
                ->orWhere('billboard_in.site_number', 'LIKE', "%{$searchValue}%")
                ->orWhere('billboard_in.type', 'LIKE', "%{$searchValue}%")
                ->orWhere('billboard_in.size', 'LIKE', "%{$searchValue}%")
                ->orWhere('billboard_out.site_number', 'LIKE', "%{$searchValue}%")
                ->orWhere('transactions_in.remarks', 'LIKE', "%{$searchValue}%")
                ->orWhere('transactions_out.remarks', 'LIKE', "%{$searchValue}%")
                ->orWhere('contractors.company_name', 'LIKE', "%{$searchValue}%")
                ->orWhere('contractors.name', 'LIKE', "%{$searchValue}%")
                ->orWhere('contractors.phone', 'LIKE', "%{$searchValue}%");
            });
        }

        $totalFiltered = $query->count();

        $filteredData = $query->skip($start)->take($limit)->get();

        $data = [];
        foreach ($filteredData as $d) {
            $data[] = [
                // Display data (existing)
                'client_in_name'     => $d->client_in_name,
                'billboard_in_site'  => $d->billboard_in_site,
                'site_in'            => $d->site_in,
                'billboard_in_type'  => $d->billboard_in_type,
                'billboard_in_size'  => $d->billboard_in_size,
                'balance_contractor' => $d->balance_contractor,
                'balance_bgoc'       => $d->balance_bgoc,
                'remarks_in'         => $d->remarks_in,
                'quantity_in'        => $d->quantity_in,
                'date_in'            => $d->date_in ? Carbon::parse($d->date_in)->format('d/m/y') : null,
                'transaction_in_id'  => $d->transaction_in_id,

                'client_out_name'    => $d->client_out_name,
                'billboard_out_site' => $d->billboard_out_site,
                'site_out'           => $d->site_out,
                'billboard_out_size' => $d->billboard_out_size,
                'remarks_out'        => $d->remarks_out,
                'quantity_out'       => $d->quantity_out,
                'date_out'           => $d->date_out ? Carbon::parse($d->date_out)->format('d/m/y') : null,
                'transaction_out_id' => $d->transaction_out_id,

                'contractor'         => $d->contractor_company . ' (' . $d->contractor_name . ')',
                'contractor_phone'   => $d->contractor_phone,
                'stock_inventory_id' => $d->id,

                // ✅ NEW: Add missing fields for edit functionality
                'contractor_id'      => $d->contractor_id,
                'client_in_id'       => $d->client_in_id,
                'client_out_id'      => $d->client_out_id,
                'site_in_id'         => $d->site_in_id,
                'site_out_id'        => $d->site_out_id,
                'type_in'            => $d->type_in,
                'size_in'            => $d->size_in,
                'type_out'           => $d->type_out,
                'size_out'           => $d->size_out,
            ];
        }

        logger('data: ' , $data);

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
        ]);
    }



    public function create(Request $request)
    {
        logger('data masuk: ', $request->all());

        // 1️⃣ Validation
        $validated = Validator::make($request->all(), [
            'contractor_id'    => 'required|exists:contractors,id',
            'remarks_in'       => 'nullable|string',
            'remarks_out'      => 'nullable|string',
            'bal_contractor'   => 'nullable|integer',
            'bal_bgoc'         => 'nullable|integer',
            'sites_in'         => 'nullable|array',
            'sites_in.*.id'    => 'nullable|exists:billboards,id',
            'sites_in.*.qty'   => 'nullable|integer|min:0',
            'sites_in.*.client_id' => 'nullable|exists:client_companies,id',
            'date_in'          => 'nullable|date',
            'date_out'         => 'nullable|date',
            'sites_out'        => 'nullable|array',
            'sites_out.*.id'   => 'nullable|exists:billboards,id',
            'sites_out.*.qty'  => 'nullable|integer|min:0',
            'sites_out.*.client_id' => 'nullable|exists:client_companies,id',
        ])->validate();

        // 2️⃣ Wrap in DB transaction to ensure atomic save
        DB::transaction(function() use ($validated, &$inventory) {

            // Find existing inventory or create new
            $inventory = StockInventory::firstOrNew(
                ['contractor_id' => $validated['contractor_id']]
            );

            // Increment balances
            $inventory->balance_contractor = ($inventory->balance_contractor ?? 0) + ($validated['bal_contractor'] ?? 0);
            $inventory->balance_bgoc       = ($inventory->balance_bgoc ?? 0) + ($validated['bal_bgoc'] ?? 0);
            $inventory->save();

            $userId = auth()->id() ?? 1; // fallback user ID if auth not set

            // 3️⃣ Add IN transactions
            if (!empty($validated['sites_in'])) {
                foreach ($validated['sites_in'] as $site) {
                    $inventory->transactions()->create([
                        'billboard_id'     => $site['id'],
                        'client_id'        => $site['client_id'] ?? null,
                        'type'             => 'in',
                        'quantity'         => $site['qty'] ?? 0,
                        'transaction_date' => isset($validated['date_in'])
                                                ? Carbon::parse($validated['date_in'])->format('Y-m-d H:i:s')
                                                : now(),
                        'remarks'          => $validated['remarks_in'] ?? null,
                        'created_by'       => $userId,
                    ]);
                }
            }

            // 4️⃣ Add OUT transactions
            if (!empty($validated['sites_out'])) {
                foreach ($validated['sites_out'] as $site) {
                    $inventory->transactions()->create([
                        'billboard_id'     => $site['id'],
                        'client_id'        => $site['client_id'] ?? null,
                        'type'             => 'out',
                        'quantity'         => $site['qty'] ?? 0,
                        'transaction_date' => isset($validated['date_out'])
                                                ? Carbon::parse($validated['date_out'])->format('Y-m-d H:i:s')
                                                : now(),
                        'remarks'          => $validated['remarks_out'] ?? null,
                        'created_by'       => $userId,
                    ]);
                }
            }
        });

        // 5️⃣ Return response with transactions
        return response()->json([
            'success' => true,
            'message' => 'Inventory saved successfully.',
            'data'    => $inventory->load('transactions'),
        ]);
    }

    public function edit(Request $request)
    {
        logger('edit request:', $request->all());

        $validated = Validator::make($request->all(), [
            'transaction_id'      => 'required|integer|exists:stock_inventory_transactions,id',
            'contractor_id'       => 'required|exists:contractors,id',
            'remarks_in'          => 'nullable|string|max:255',
            'remarks_out'         => 'nullable|string|max:255',
            'client_in'           => 'nullable|integer|exists:client_companies,id',
            'site_in'             => 'nullable|integer|exists:billboards,id',
            'qty_in'              => 'nullable|integer|min:0',
            'client_out'          => 'nullable|integer|exists:client_companies,id',
            'site_out'            => 'nullable|integer|exists:billboards,id',
            'qty_out'             => 'nullable|integer|min:0',
            'date_in'             => 'nullable|date',
            'date_out'            => 'nullable|date',
        ])->validate();

        DB::transaction(function() use ($validated, &$inventory) {

            $transaction = StockInventoryTransaction::findOrFail($validated['transaction_id']);
            $inventory   = $transaction->stockInventory;
            $userId      = auth()->id() ?? 1;

            // --- Update IN transaction ---
            if (!empty($validated['site_in'])) {
                $inTransaction = StockInventoryTransaction::firstOrNew([
                    'id' => $transaction->id,
                    'stock_inventory_id' => $inventory->id,
                    'type'               => 'in',
                    'billboard_id'       => $validated['site_in'],
                ]);

                // **Add new quantity instead of overwriting**
                $inTransaction->quantity = $validated['qty_in'] ?? 0;
                $inTransaction->client_id        = $validated['client_in'] ?? $inTransaction->client_id;
                $inTransaction->transaction_date = isset($validated['date_in'])
                                                    ? Carbon::parse($validated['date_in'])->format('Y-m-d H:i:s')
                                                    : now();
                $inTransaction->remarks    = $validated['remarks_in'] ?? $inTransaction->remarks;
                $inTransaction->created_by = $userId;
                $inTransaction->save();
            }

            // --- Update OUT transaction ---
            if (!empty($validated['site_out'])) {
                $outTransaction = StockInventoryTransaction::firstOrNew([
                    'id' => $transaction->id,
                    'stock_inventory_id' => $inventory->id,
                    'type'               => 'out',
                    'billboard_id'       => $validated['site_out'],
                ]);

                $outTransaction->quantity = $validated['qty_out'] ?? 0;
                $outTransaction->client_id        = $validated['client_out'] ?? $outTransaction->client_id;
                $outTransaction->transaction_date = isset($validated['date_out'])
                                                    ? Carbon::parse($validated['date_out'])->format('Y-m-d H:i:s')
                                                    : now();
                $outTransaction->remarks    = $validated['remarks_out'] ?? $outTransaction->remarks;
                $outTransaction->created_by = $userId;
                $outTransaction->save();
            }

            // --- Recalculate balances ---
            $inventory->balance_contractor = StockInventoryTransaction::where('stock_inventory_id', $inventory->id)
                                            ->where('type', 'in')
                                            ->sum('quantity');
            $inventory->balance_bgoc = StockInventoryTransaction::where('stock_inventory_id', $inventory->id)
                                            ->where('type', 'out')
                                            ->sum('quantity');
            $inventory->save();
        });

        return response()->json([
            'success' => true,
            'message' => 'Stock inventory updated successfully.',
            'data'    => $inventory->load('transactions'),
        ]);
    }






    /**
     * Delete stock inventory.
     */
    public function delete(Request $request)
    {
        $id = $request->id;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'id' => [
                    'required',
                    'integer',
                    'exists:stock_inventory_transactions,id',
                ],
            ],
            [
                'id.exists' => 'The stock inventory cannot be found.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            DB::beginTransaction();

            // Get transaction first
            $transaction = StockInventoryTransaction::findOrFail($id);

            // Find related stock inventory
            $stockInventory = StockInventory::findOrFail($transaction->stock_inventory_id);

            // Adjust balances depending on type
            if ($transaction->type === 'in') {
                $stockInventory->balance_contractor -= $transaction->quantity;
            } elseif ($transaction->type === 'out') {
                $stockInventory->balance_bgoc -= $transaction->quantity;
            }

            // Prevent negative values
            $stockInventory->balance_contractor = max(0, $stockInventory->balance_contractor);
            $stockInventory->balance_bgoc = max(0, $stockInventory->balance_bgoc);

            // Save updated balances
            $stockInventory->save();

            // Delete the transaction
            $transaction->delete();

            DB::commit();

            return response()->json([
                "success" => "Transaction deleted and balances updated successfully.",
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

}
