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
     * Show the stock inventory users list.
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
    //     ];

    //     $limit = $request->input('length');
    //     $start = $request->input('start');
    //     $orderColumnIndex = $request->input('order.0.column');
    //     $orderColumnName = $columns[$orderColumnIndex] ?? 'stock_inventories.id';
    //     $orderDirection = $request->input('order.0.dir', 'asc');

    //     // Subquery for IN transactions aggregated per stock_inventory
    //     $inSub = DB::table('stock_inventory_transactions as t_in')
    //         ->select(
    //             'stock_inventory_id',
    //             DB::raw("GROUP_CONCAT(quantity SEPARATOR ',') as quantity_in"),
    //             DB::raw("GROUP_CONCAT(remarks SEPARATOR ', ') as remarks_in"),
    //             DB::raw("GROUP_CONCAT(transaction_date SEPARATOR ',') as date_in"),
    //             DB::raw("GROUP_CONCAT(client_companies.name SEPARATOR ',') as client_in_name"),
    //             DB::raw("GROUP_CONCAT(billboards.site_number SEPARATOR ',') as site_in")
    //         )
    //         ->leftJoin('client_companies', 'client_companies.id', '=', 't_in.client_id')
    //         ->leftJoin('billboards', 'billboards.id', '=', 't_in.billboard_id')
    //         ->where('t_in.type', 'in')
    //         ->groupBy('stock_inventory_id');

    //     // Subquery for OUT transactions aggregated per stock_inventory
    //     $outSub = DB::table('stock_inventory_transactions as t_out')
    //         ->select(
    //             'stock_inventory_id',
    //             DB::raw("GROUP_CONCAT(quantity SEPARATOR ',') as quantity_out"),
    //             DB::raw("GROUP_CONCAT(remarks SEPARATOR ', ') as remarks_out"),
    //             DB::raw("GROUP_CONCAT(transaction_date SEPARATOR ',') as date_out"),
    //             DB::raw("GROUP_CONCAT(client_companies.name SEPARATOR ',') as client_out_name"),
    //             DB::raw("GROUP_CONCAT(billboards.site_number SEPARATOR ',') as site_out")
    //         )
    //         ->leftJoin('client_companies', 'client_companies.id', '=', 't_out.client_id')
    //         ->leftJoin('billboards', 'billboards.id', '=', 't_out.billboard_id')
    //         ->where('t_out.type', 'out')
    //         ->groupBy('stock_inventory_id');

    //     $query = StockInventory::select(
    //         'stock_inventories.*',
    //         'contractors.name as contractor_name',
    //         'contractors.company_name as contractor_company',
    //         'contractors.phone as contractor_phone',
    //         'in_agg.quantity_in',
    //         'in_agg.remarks_in',
    //         'in_agg.date_in',
    //         'in_agg.client_in_name',
    //         'in_agg.site_in',
    //         'out_agg.quantity_out',
    //         'out_agg.remarks_out',
    //         'out_agg.date_out',
    //         'out_agg.client_out_name',
    //         'out_agg.site_out'
    //     )
    //     ->leftJoinSub($inSub, 'in_agg', function($join){
    //         $join->on('in_agg.stock_inventory_id', '=', 'stock_inventories.id');
    //     })
    //     ->leftJoinSub($outSub, 'out_agg', function($join){
    //         $join->on('out_agg.stock_inventory_id', '=', 'stock_inventories.id');
    //     })
    //     ->leftJoin('contractors', 'contractors.id', '=', 'stock_inventories.contractor_id');

    //     // Apply search
    //     $searchValue = trim($request->input('search.value'));
    //     if (!empty($searchValue)) {
    //         $query->where(function($q) use ($searchValue){
    //             $q->where('contractors.name','LIKE',"%{$searchValue}%")
    //             ->orWhere('contractors.company_name','LIKE',"%{$searchValue}%")
    //             ->orWhere('in_agg.remarks_in','LIKE',"%{$searchValue}%")
    //             ->orWhere('out_agg.remarks_out','LIKE',"%{$searchValue}%");
    //         });
    //     }

    //     $totalData = $query->count();
    //     $totalFiltered = $totalData;

    //     $data = $query->skip($start)->take($limit)->get()->map(function($d){
    //         return [
    //             'contractor' => $d->contractor_company . ' (' . $d->contractor_name . ')',
    //             'balance_contractor' => $d->balance_contractor,
    //             'balance_bgoc' => $d->balance_bgoc,
    //             'quantity_in' => $d->quantity_in,
    //             'remarks_in' => $d->remarks_in,
    //             'date_in' => $d->date_in,
    //             'quantity_out' => $d->quantity_out,
    //             'remarks_out' => $d->remarks_out,
    //             'date_out' => $d->date_out,
    //             'stock_inventory_id' => $d->id,
    //             'client_in_name' => $d->client_in_name ?? '',
    //             'client_out_name' => $d->client_out_name ?? '',
    //             'site_in'        => $d->site_in ?? '',
    //             'site_out'       => $d->site_out ?? '',
    //         ];
    //     });

    //     logger('data list: ' . $data);

    //     return response()->json([
    //         "draw" => intval($request->input('draw')),
    //         "recordsTotal" => intval($totalData),
    //         "recordsFiltered" => intval($totalFiltered),
    //         "data" => $data,
    //     ]);
    // }

    public function list(Request $request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        // Subquery for IN transactions aggregated per stock_inventory
        $inSub = DB::table('stock_inventory_transactions as t_in')
            ->select(
                't_in.stock_inventory_id',
                DB::raw("GROUP_CONCAT(t_in.id SEPARATOR ',') as transaction_in_ids"),
                DB::raw("GROUP_CONCAT(quantity SEPARATOR ',') as quantity_in"),
                DB::raw("GROUP_CONCAT(remarks SEPARATOR ', ') as remarks_in"),
                DB::raw("GROUP_CONCAT(transaction_date SEPARATOR ',') as date_in"),
                DB::raw("GROUP_CONCAT(client_companies.name SEPARATOR ',') as client_in_name"),
                DB::raw("GROUP_CONCAT(CONCAT(billboards.site_number, ' - ', locations.name) SEPARATOR ',') as site_in"),
                DB::raw("GROUP_CONCAT(billboards.type SEPARATOR ',') as billboard_type_in"),
                DB::raw("GROUP_CONCAT(billboards.size SEPARATOR ',') as billboard_size_in")

            )
            ->leftJoin('client_companies', 'client_companies.id', '=', 't_in.client_id')
            ->leftJoin('billboards', 'billboards.id', '=', 't_in.billboard_id')
            ->leftJoin('locations', 'locations.id', '=', 'billboards.location_id')
            ->where('t_in.type', 'in')
            ->groupBy('t_in.stock_inventory_id');

        // Subquery for OUT transactions aggregated per stock_inventory
        $outSub = DB::table('stock_inventory_transactions as t_out')
            ->select(
                't_out.stock_inventory_id',
                DB::raw("GROUP_CONCAT(t_out.id SEPARATOR ',') as transaction_out_ids"),
                DB::raw("GROUP_CONCAT(quantity SEPARATOR ',') as quantity_out"),
                DB::raw("GROUP_CONCAT(remarks SEPARATOR ', ') as remarks_out"),
                DB::raw("GROUP_CONCAT(transaction_date SEPARATOR ',') as date_out"),
                DB::raw("GROUP_CONCAT(client_companies.name SEPARATOR ',') as client_out_name"),
                DB::raw("GROUP_CONCAT(CONCAT(billboards.site_number, ' - ', locations.name) SEPARATOR ',') as site_out"),
                DB::raw("GROUP_CONCAT(billboards.type SEPARATOR ',') as billboard_type_out"),
                DB::raw("GROUP_CONCAT(billboards.size SEPARATOR ',') as billboard_size_out")

            )
            ->leftJoin('client_companies', 'client_companies.id', '=', 't_out.client_id')
            ->leftJoin('billboards', 'billboards.id', '=', 't_out.billboard_id')
            ->leftJoin('locations', 'locations.id', '=', 'billboards.location_id')
            ->where('t_out.type', 'out')
            ->groupBy('t_out.stock_inventory_id');

        $query = StockInventory::select(
            'stock_inventories.*',
            'contractors.name as contractor_name',
            'contractors.company_name as contractor_company',
            'contractors.phone as contractor_phone',
            'in_agg.transaction_in_ids',
            'in_agg.quantity_in',
            'in_agg.remarks_in',
            'in_agg.date_in',
            'in_agg.client_in_name',
            'in_agg.site_in',
            'in_agg.billboard_type_in',
            'in_agg.billboard_size_in',
            'out_agg.transaction_out_ids',
            'out_agg.quantity_out',
            'out_agg.remarks_out',
            'out_agg.date_out',
            'out_agg.client_out_name',
            'out_agg.site_out',
            'out_agg.billboard_type_out',
            'out_agg.billboard_size_out'
        )
        ->leftJoinSub($inSub, 'in_agg', function($join){
            $join->on('in_agg.stock_inventory_id', '=', 'stock_inventories.id');
        })
        ->leftJoinSub($outSub, 'out_agg', function($join){
            $join->on('out_agg.stock_inventory_id', '=', 'stock_inventories.id');
        })
        ->leftJoin('contractors', 'contractors.id', '=', 'stock_inventories.contractor_id')
        ->orderBy('stock_inventories.id', 'asc');

        $totalData = $query->count();

        $data = $query->skip($start)->take($limit)->get()->flatMap(function($d){
            // IN data
            $inIds     = $d->transaction_in_ids ? explode(',', $d->transaction_in_ids) : [];
            $inDates = $d->date_in ? explode(',', $d->date_in) : [];
            $inRemarks = $d->remarks_in ? explode(', ', $d->remarks_in) : [];
            $inQty = $d->quantity_in ? explode(',', $d->quantity_in) : [];
            $inClients = $d->client_in_name ? explode(',', $d->client_in_name) : [];
            $inSites = $d->site_in ? explode(',', $d->site_in) : [];
            $inTypes   = $d->billboard_type_in ? explode(',', $d->billboard_type_in) : [];
            $inSizes   = $d->billboard_size_in ? explode(',', $d->billboard_size_in) : [];

            // OUT data
            $outIds     = $d->transaction_out_ids ? explode(',', $d->transaction_out_ids) : [];
            $outDates = $d->date_out ? explode(',', $d->date_out) : [];
            $outRemarks = $d->remarks_out ? explode(', ', $d->remarks_out) : [];
            $outQty = $d->quantity_out ? explode(',', $d->quantity_out) : [];
            $outClients = $d->client_out_name ? explode(',', $d->client_out_name) : [];
            $outSites = $d->site_out ? explode(',', $d->site_out) : [];
            $outTypes   = $d->billboard_type_out ? explode(',', $d->billboard_type_out) : [];
            $outSizes   = $d->billboard_size_out ? explode(',', $d->billboard_size_out) : [];

            // Max number of rows between IN and OUT
            $rowCount = max(count($inDates), count($outDates), 1);

            $rows = [];
            for ($i = 0; $i < $rowCount; $i++) {
                $rows[] = [
                    'contractor' => $d->contractor_company . ' (' . $d->contractor_name . ')',
                    'balance_contractor' => $d->balance_contractor,
                    'balance_bgoc' => $d->balance_bgoc,

                    // IN columns
                    'transaction_in_id' => $inIds[$i] ?? '',
                    'date_in' => $inDates[$i] ?? '' ? Carbon::parse($inDates[$i])->format('d/m/y') : '',
                    'remarks_in' => $inRemarks[$i] ?? '',
                    'quantity_in' => $inQty[$i] ?? '',
                    'client_in_name' => $inClients[$i] ?? '',
                    'site_in' => $inSites[$i] ?? '',
                    'billboard_type_in' => $inTypes[$i] ?? '',
                    'billboard_size_in' => $inSizes[$i] ?? '',

                    // OUT columns
                    'transaction_out_id' => $outIds[$i] ?? '',
                    'date_out' => $outDates[$i] ?? '' ? Carbon::parse($outDates[$i])->format('d/m/y') : '',
                    'remarks_out' => $outRemarks[$i] ?? '',
                    'quantity_out' => $outQty[$i] ?? '',
                    'client_out_name' => $outClients[$i] ?? '',
                    'site_out' => $outSites[$i] ?? '',
                    'billboard_type_out' => $outTypes[$i] ?? '',
                    'billboard_size_out' => $outSizes[$i] ?? '',

                    'stock_inventory_id' => $d->id
                ];
            }

            return $rows;
        });

        logger('list data: ' . $data);


        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalData,
            "data" => $data,
        ]);
    }

    public function transactionsList(Request $request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        // Subquery for IN transactions aggregated per stock_inventory
        $inSub = DB::table('stock_inventory_transactions as t_in')
            ->select(
                't_in.stock_inventory_id',
                DB::raw("GROUP_CONCAT(t_in.id SEPARATOR ',') as transaction_in_ids"),
                DB::raw("GROUP_CONCAT(quantity SEPARATOR ',') as quantity_in"),
                DB::raw("GROUP_CONCAT(remarks SEPARATOR ', ') as remarks_in"),
                DB::raw("GROUP_CONCAT(transaction_date SEPARATOR ',') as date_in"),
                DB::raw("GROUP_CONCAT(client_companies.name SEPARATOR ',') as client_in_name"),
                DB::raw("GROUP_CONCAT(CONCAT(billboards.site_number, ' - ', locations.name) SEPARATOR ',') as site_in"),
                DB::raw("GROUP_CONCAT(billboards.type SEPARATOR ',') as billboard_type_in"),
                DB::raw("GROUP_CONCAT(billboards.size SEPARATOR ',') as billboard_size_in")

            )
            ->leftJoin('client_companies', 'client_companies.id', '=', 't_in.client_id')
            ->leftJoin('billboards', 'billboards.id', '=', 't_in.billboard_id')
            ->leftJoin('locations', 'locations.id', '=', 'billboards.location_id')
            ->where('t_in.type', 'in')
            ->groupBy('t_in.stock_inventory_id');

        // Subquery for OUT transactions aggregated per stock_inventory
        $outSub = DB::table('stock_inventory_transactions as t_out')
            ->select(
                't_out.stock_inventory_id',
                DB::raw("GROUP_CONCAT(t_out.id SEPARATOR ',') as transaction_out_ids"),
                DB::raw("GROUP_CONCAT(quantity SEPARATOR ',') as quantity_out"),
                DB::raw("GROUP_CONCAT(remarks SEPARATOR ', ') as remarks_out"),
                DB::raw("GROUP_CONCAT(transaction_date SEPARATOR ',') as date_out"),
                DB::raw("GROUP_CONCAT(client_companies.name SEPARATOR ',') as client_out_name"),
                DB::raw("GROUP_CONCAT(CONCAT(billboards.site_number, ' - ', locations.name) SEPARATOR ',') as site_out"),
                DB::raw("GROUP_CONCAT(billboards.type SEPARATOR ',') as billboard_type_out"),
                DB::raw("GROUP_CONCAT(billboards.size SEPARATOR ',') as billboard_size_out")

            )
            ->leftJoin('client_companies', 'client_companies.id', '=', 't_out.client_id')
            ->leftJoin('billboards', 'billboards.id', '=', 't_out.billboard_id')
            ->leftJoin('locations', 'locations.id', '=', 'billboards.location_id')
            ->where('t_out.type', 'out')
            ->groupBy('t_out.stock_inventory_id');

        $query = StockInventory::select(
            'stock_inventories.*',
            'contractors.name as contractor_name',
            'contractors.company_name as contractor_company',
            'contractors.phone as contractor_phone',
            'in_agg.transaction_in_ids',
            'in_agg.quantity_in',
            'in_agg.remarks_in',
            'in_agg.date_in',
            'in_agg.client_in_name',
            'in_agg.site_in',
            'in_agg.billboard_type_in',
            'in_agg.billboard_size_in',
            'out_agg.transaction_out_ids',
            'out_agg.quantity_out',
            'out_agg.remarks_out',
            'out_agg.date_out',
            'out_agg.client_out_name',
            'out_agg.site_out',
            'out_agg.billboard_type_out',
            'out_agg.billboard_size_out'
        )
        ->leftJoinSub($inSub, 'in_agg', function($join){
            $join->on('in_agg.stock_inventory_id', '=', 'stock_inventories.id');
        })
        ->leftJoinSub($outSub, 'out_agg', function($join){
            $join->on('out_agg.stock_inventory_id', '=', 'stock_inventories.id');
        })
        ->leftJoin('contractors', 'contractors.id', '=', 'stock_inventories.contractor_id')
        ->orderBy('stock_inventories.id', 'asc');

        $totalData = $query->count();

        $data = $query->skip($start)->take($limit)->get()->flatMap(function($d){
            // IN data
            $inIds     = $d->transaction_in_ids ? explode(',', $d->transaction_in_ids) : [];
            $inDates = $d->date_in ? explode(',', $d->date_in) : [];
            $inRemarks = $d->remarks_in ? explode(', ', $d->remarks_in) : [];
            $inQty = $d->quantity_in ? explode(',', $d->quantity_in) : [];
            $inClients = $d->client_in_name ? explode(',', $d->client_in_name) : [];
            $inSites = $d->site_in ? explode(',', $d->site_in) : [];
            $inTypes   = $d->billboard_type_in ? explode(',', $d->billboard_type_in) : [];
            $inSizes   = $d->billboard_size_in ? explode(',', $d->billboard_size_in) : [];

            // OUT data
            $outIds     = $d->transaction_out_ids ? explode(',', $d->transaction_out_ids) : [];
            $outDates = $d->date_out ? explode(',', $d->date_out) : [];
            $outRemarks = $d->remarks_out ? explode(', ', $d->remarks_out) : [];
            $outQty = $d->quantity_out ? explode(',', $d->quantity_out) : [];
            $outClients = $d->client_out_name ? explode(',', $d->client_out_name) : [];
            $outSites = $d->site_out ? explode(',', $d->site_out) : [];
            $outTypes   = $d->billboard_type_out ? explode(',', $d->billboard_type_out) : [];
            $outSizes   = $d->billboard_size_out ? explode(',', $d->billboard_size_out) : [];

            // Max number of rows between IN and OUT
            $rowCount = max(count($inDates), count($outDates), 1);

            $rows = [];
            for ($i = 0; $i < $rowCount; $i++) {
                $rows[] = [
                    'contractor' => $d->contractor_company . ' (' . $d->contractor_name . ')',
                    'balance_contractor' => $d->balance_contractor,
                    'balance_bgoc' => $d->balance_bgoc,

                    // IN columns
                    'transaction_in_id' => $inIds[$i] ?? '',
                    'date_in' => $inDates[$i] ?? '' ? Carbon::parse($inDates[$i])->format('d/m/y') : '',
                    'remarks_in' => $inRemarks[$i] ?? '',
                    'quantity_in' => $inQty[$i] ?? '',
                    'client_in_name' => $inClients[$i] ?? '',
                    'site_in' => $inSites[$i] ?? '',
                    'billboard_type_in' => $inTypes[$i] ?? '',
                    'billboard_size_in' => $inSizes[$i] ?? '',

                    // OUT columns
                    'transaction_out_id' => $outIds[$i] ?? '',
                    'date_out' => $outDates[$i] ?? '' ? Carbon::parse($outDates[$i])->format('d/m/y') : '',
                    'remarks_out' => $outRemarks[$i] ?? '',
                    'quantity_out' => $outQty[$i] ?? '',
                    'client_out_name' => $outClients[$i] ?? '',
                    'site_out' => $outSites[$i] ?? '',
                    'billboard_type_out' => $outTypes[$i] ?? '',
                    'billboard_size_out' => $outSizes[$i] ?? '',

                    'stock_inventory_id' => $d->id
                ];
            }

            return $rows;
        });

        logger('list data: ' . $data);


        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalData,
            "data" => $data,
        ]);
    }


    public function editData($stockInventoryId, Request $request)
    {
        $transactionInId  = $request->get('transaction_in_id');
        $transactionOutId = $request->get('transaction_out_id');

        $transactionIn  = $transactionInId
            ? StockInventoryTransaction::with(['contractor','client','billboard','stockInventory'])
                ->find($transactionInId)
            : null;

        $transactionOut = $transactionOutId
            ? StockInventoryTransaction::with(['contractor','client','billboard','stockInventory'])
                ->find($transactionOutId)
            : null;

        logger('in: ' . $transactionIn);
        logger('out: ' . $transactionOut);

        return response()->json([
            'in'  => $transactionIn ? [
                'id'                => $transactionIn->id,
                'contractor_id'     => $transactionIn->stockInventory->contractor_id ?? null,
                'contractor_name'   => $transactionIn->contractor->name ?? '',
                'balance_contractor'=> $transactionIn->stockInventory->balance_contractor ?? 0,
                'balance_bgoc'      => $transactionIn->stockInventory->balance_bgoc ?? 0,
                'transaction_date'  => $transactionIn->transaction_date ? Carbon::parse($transactionIn->transaction_date)->format('Y-m-d') : null,
                'client_id'         => $transactionIn->client_id,
                'client_name'       => $transactionIn->client->name ?? '',
                'billboard_id'      => $transactionIn->billboard_id,
                'site_number'       => $transactionIn->billboard->site_number ?? '',
                'type'              => $transactionIn->billboard->type,
                'size'              => $transactionIn->billboard->size ?? '',
                'quantity'          => $transactionIn->quantity,
                'remarks'           => $transactionIn->remarks,
            ] : null,

            'out' => $transactionOut ? [
                'id'                => $transactionOut->id,
                'contractor_id'     => $transactionOut->stockInventory->contractor_id ?? null,
                'contractor_name'   => $transactionOut->contractor->name ?? '',
                'balance_contractor'=> $transactionOut->stockInventory->balance_contractor ?? 0,
                'balance_bgoc'      => $transactionOut->stockInventory->balance_bgoc ?? 0,
                'transaction_date'  => $transactionOut->transaction_date ? Carbon::parse($transactionOut->transaction_date)->format('Y-m-d') : null,
                'client_id'         => $transactionOut->client_id,
                'client_name'       => $transactionOut->client->name ?? '',
                'billboard_id'      => $transactionOut->billboard_id,
                'site_number'       => $transactionOut->billboard->site_number ?? '',
                'type'              => $transactionOut->billboard->type,
                'size'              => $transactionOut->billboard->size ?? '',
                'quantity'          => $transactionOut->quantity,
                'remarks'           => $transactionOut->remarks,
            ] : null,
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
            'balance_contractor'   => 'nullable|integer',
            'balance_bgoc'         => 'nullable|integer',
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

        try {

            // 2️⃣ Wrap in DB transaction to ensure atomic save
            DB::transaction(function() use ($validated, &$inventory) {

                // Find existing inventory or create new
                $inventory = StockInventory::firstOrNew(
                    ['contractor_id' => $validated['contractor_id']]
                );

                // Increment balances
                $inventory->balance_contractor = ($inventory->balance_contractor ?? 0) + ($validated['balance_contractor'] ?? 0);
                $inventory->balance_bgoc       = ($inventory->balance_bgoc ?? 0) + ($validated['balance_bgoc'] ?? 0);
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
        } catch (\Exception $e) {
            // If any queries fail, undo all changes
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function edit(Request $request)
    {
        logger('edit request:', $request->all());

        $validated = Validator::make($request->all(), [
            'stock_inventory_id' => 'required|integer|exists:stock_inventories,id',

            'transaction_in_id'  => 'nullable|integer|exists:stock_inventory_transactions,id',
            'transaction_out_id' => 'nullable|integer|exists:stock_inventory_transactions,id',

            'contractor_id'      => 'nullable|exists:contractors,id',

            'remarks_in'         => 'nullable|string|max:255',
            'remarks_out'        => 'nullable|string|max:255',

            'client_in'          => 'nullable|integer|exists:client_companies,id',
            'site_in'            => 'nullable|integer|exists:billboards,id',
            'qty_in'             => 'nullable|integer|min:0',
            'date_in'            => 'nullable|date',

            'client_out'         => 'nullable|integer|exists:client_companies,id',
            'site_out'           => 'nullable|integer|exists:billboards,id',
            'qty_out'            => 'nullable|integer|min:0',
            'date_out'           => 'nullable|date',
        ])->validate();

        $inventory = StockInventory::findOrFail($validated['stock_inventory_id']);
        $userId    = auth()->id() ?? 1;

        try {

            DB::transaction(function () use ($validated, $inventory, $userId) {
                // --- Update IN transaction ---
                if (!empty($validated['site_in'])) {
                    $inTransaction = !empty($validated['transaction_in_id'])
                        ? StockInventoryTransaction::findOrFail($validated['transaction_in_id'])
                        : new StockInventoryTransaction();

                    $inTransaction->stock_inventory_id = $inventory->id;
                    $inTransaction->type               = 'in';
                    $inTransaction->billboard_id       = $validated['site_in'];
                    $inTransaction->client_id          = $validated['client_in'] ?? null;
                    $inTransaction->quantity           = $validated['qty_in'] ?? 0;
                    $inTransaction->transaction_date   = !empty($validated['date_in'])
                                                            ? Carbon::parse($validated['date_in'])->format('Y-m-d H:i:s')
                                                            : now();
                    $inTransaction->remarks    = $validated['remarks_in'] ?? null;
                    $inTransaction->created_by = $userId;
                    $inTransaction->save();
                }

                // --- Update OUT transaction ---
                if (!empty($validated['site_out'])) {
                    $outTransaction = !empty($validated['transaction_out_id'])
                        ? StockInventoryTransaction::findOrFail($validated['transaction_out_id'])
                        : new StockInventoryTransaction();

                    $outTransaction->stock_inventory_id = $inventory->id;
                    $outTransaction->type               = 'out';
                    $outTransaction->billboard_id       = $validated['site_out'];
                    $outTransaction->client_id          = $validated['client_out'] ?? null;
                    $outTransaction->quantity           = $validated['qty_out'] ?? 0;
                    $outTransaction->transaction_date   = !empty($validated['date_out'])
                                                            ? Carbon::parse($validated['date_out'])->format('Y-m-d H:i:s')
                                                            : now();
                    $outTransaction->remarks    = $validated['remarks_out'] ?? null;
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
        } catch (\Exception $e) {
            // If any queries fail, undo all changes
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 422);
        }
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
