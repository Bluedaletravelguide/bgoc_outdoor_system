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
    public function list(Request $request)
    {
        $columns = [
            0  => 'client_in.name',
            1  => 'billboard_in.site_number',
            2  => 'billboard_in.type',
            3  => 'billboard_in.size',
            4  => 'stock_inventory.balance_contractor',
            5  => 'stock_inventory.balance_bgoc',
            6  => 'stock_inventory.remarks_in',
            7  => 'in_site.quantity',
            8  => 'stock_inventory.date_in',
            9  => 'client_out.name',
            10 => 'billboard_out.site_number',
            11 => 'stock_inventory.remarks_out',
            12 => 'out_site.quantity',
            13 => 'stock_inventory.date_out',
            14 => 'contractors.company_name',
            15 => 'stock_inventory.id',
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $columns[$orderColumnIndex] ?? 'stock_inventory.id';
        $orderDirection = $request->input('order.0.dir', 'asc');

        // Base query with joins
        $query = StockInventory::select(
                'stock_inventory.*',
                'client_in.name as client_in_name',
                'client_out.name as client_out_name',
                'billboard_in.site_number as billboard_in_site',
                'billboard_in.type as billboard_in_type',
                'billboard_in.size as billboard_in_size',
                'billboard_out.site_number as billboard_out_site',
                'billboard_out.size as billboard_out_size',
                'in_site.quantity as quantity_in',
                'out_site.quantity as quantity_out',
                'contractors.company_name as contractor_company',
                'contractors.name as contractor_name',
                'contractors.phone as contractor_phone'
            )
            ->leftJoin('client_companies as client_in', 'client_in.id', '=', 'stock_inventory.client_in')
            ->leftJoin('client_companies as client_out', 'client_out.id', '=', 'stock_inventory.client_out')
            // Join for IN sites
            ->leftJoin('stock_inventory_sites as in_site', function($join) {
                $join->on('in_site.stock_inventory_id', '=', 'stock_inventory.id')
                    ->where('in_site.type', '=', 'in');
            })
            ->leftJoin('billboards as billboard_in', 'billboard_in.id', '=', 'in_site.billboard_id')
            // Join for OUT sites
            ->leftJoin('stock_inventory_sites as out_site', function($join) {
                $join->on('out_site.stock_inventory_id', '=', 'stock_inventory.id')
                    ->where('out_site.type', '=', 'out');
            })
            ->leftJoin('billboards as billboard_out', 'billboard_out.id', '=', 'out_site.billboard_id')
            ->leftJoin('contractors', 'contractors.id', '=', 'stock_inventory.contractor_pic')
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
                ->orWhere('stock_inventory.remarks_in', 'LIKE', "%{$searchValue}%")
                ->orWhere('stock_inventory.remarks_out', 'LIKE', "%{$searchValue}%")
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
                'client_in_name'     => $d->client_in_name,
                'billboard_in_site'  => $d->billboard_in_site,
                'billboard_in_type'  => $d->billboard_in_type,
                'billboard_in_size'  => $d->billboard_in_size,
                'balance_contractor' => $d->balance_contractor,
                'balance_bgoc'       => $d->balance_bgoc,
                'remarks_in'         => $d->remarks_in,
                'quantity_in'        => $d->quantity_in,
                'date_in'            => $d->date_in ? Carbon::parse($d->date_in)->format('d/m/y') : null,
                'client_out_name'    => $d->client_out_name,
                'billboard_out_site' => $d->billboard_out_site,
                'billboard_out_size' => $d->billboard_out_size,
                'remarks_out'        => $d->remarks_out,
                'quantity_out'       => $d->quantity_out,
                'date_out'           => $d->date_out ? Carbon::parse($d->date_out)->format('d/m/y') : null,
                'contractor'         => $d->contractor_company . ' (' . $d->contractor_name . ')',
                'contractor_phone'   => $d->contractor_phone,
                'id'                 => $d->id,
            ];
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
        ]);
    }


    /**
     * Create client.
     */
    public function create(Request $request)
    {

        // try {

            $requestData = $request->json()->all();

            logger($requestData);

            // ✅ Validate request
            $validated = Validator::make($requestData, [
                'contractor_id' => 'required|exists:contractors,id',
                'date_in'       => 'nullable|date',
                'date_out'      => 'nullable|date|after_or_equal:date_in',
                'client_in'     => 'nullable|integer|exists:client_companies,id',
                'client_out'    => 'nullable|integer|exists:client_companies,id',
                'remarks_in'    => 'nullable|string',
                'remarks_out'   => 'nullable|string',
                'bal_contractor' => 'nullable|integer',
                'bal_bgoc'       => 'nullable|integer',

                // Sites IN
                'sites_in'       => 'nullable|array',
                'sites_in.*.id'  => 'nullable|exists:billboards,id',
                'sites_in.*.qty' => 'nullable|integer|min:0',

                // Sites OUT
                'sites_out'       => 'nullable|array',
                'sites_out.*.id'  => 'nullable|exists:billboards,id',
                'sites_out.*.qty' => 'nullable|integer|min:0',
            ])->validate();

            // ✅ Save main stock inventory record
            $inventory = StockInventory::create([
                'contractor_pic'     => $request->contractor_id,
                'client_in'          => $request->client_in,
                'client_out'         => $request->client_out,
                'date_in'            => $request->date_in,
                'date_out'           => $request->date_out,
                'remarks_in'         => $request->remarks_in,
                'remarks_out'        => $request->remarks_out,
                'balance_contractor' => $request->bal_contractor,
                'balance_bgoc'       => $request->bal_bgoc,
            ]);

            logger("Inventory created with ID: " . $inventory->id);
            logger("Sites IN: " . json_encode($validated['sites_in'] ?? []));
            logger("Sites OUT: " . json_encode($validated['sites_out'] ?? []));

            // Save related sites (IN)
            if (!empty($validated['sites_in'])) {
                foreach ($validated['sites_in'] as $site) {
                    if (empty($site['id'])) continue;
                    $inventory->sites()->create([
                        'billboard_id'      => $site['id'],
                        'type'              => 'in',
                        'quantity'          => $site['qty'] ?? 0,
                        // 'stock_inventory_id' will be auto-filled because of $inventory->sites()->create()
                    ]);
                }
            }

            // Save related sites (OUT)
            if (!empty($validated['sites_out'])) {
                foreach ($validated['sites_out'] as $site) {
                    if (empty($site['id'])) continue;

                    $inventory->sites()->create([
                        'billboard_id'      => $site['id'],
                        'type'              => 'out',
                        'quantity'          => $site['qty'] ?? 0,
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Inventory created successfully.',
                'data'    => $inventory->load('sites'),
            ]);

        // } catch (\Exception $e) {
        //     return response()->json([
        //         'error' => $e->getMessage(),
        //     ], 500);
        // }
    }



    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Request $request)
    // {
    //     $id             = $request->id;
    //     $vendor         = $request->vendor;
    //     $client_in      = $request->client_in;
    //     $billboard_in   = $request->billboard_in;
    //     $quantity_in    = $request->quantity_in;
    //     $remarks_in     = $request->remarks_in;
    //     $date_in        = $request->date_in;
    //     $client_out     = $request->client_out;
    //     $billboard_out  = $request->billboard_out;
    //     $quantity_out   = $request->quantity_out;
    //     $remarks_out    = $request->remarks_out;
    //     $date_out       = $request->date_out;

    //     // Validate fields
    //     // $validator = Validator::make(
    //     //     $request->all(),
    //     //     [
    //     //         'company' => [
    //     //             'required',
    //     //             'string',
    //     //             'max:255',
    //     //         ],
    //     //         'name' => [
    //     //             'required',
    //     //             'string',
    //     //             'max:255',
    //     //         ],
    //     //         'phone' => [
    //     //             'required',
    //     //             'regex:/^\+?[0-9]+$/',
    //     //             'max:255',
    //     //         ],
    //     //     ],
    //     //     [
    //     //         'company.required' => 'The "Company Name" field is required.',
    //     //         'company.string' => 'The "Company Name" must be a string.',
    //     //         'company.max' => 'The "Company Name" must not be greater than :max characters.',

    //     //         'name.required' => 'The "Contractor PIC Name" field is required.',
    //     //         'name.string' => 'The "Contractor PIC Name" must be a string.',
    //     //         'name.max' => 'The "Contractor PIC Name" must not be greater than :max characters.',

    //     //         'phone.required' => 'The "Phone No." field is required.',
    //     //         'phone.regex' => 'The "Phone No." field must only contain "+" symbol and numbers.',
    //     //         'phone.max' => 'The "Phone No." field must not be greater than :max characters.',
    //     //     ]
    //     // );

    //     // Handle failed validations
    //     // if ($validator->fails()) {
    //     //     return response()->json(['error' => $validator->errors()->first()], 422);
    //     // }

    //     try {
    //         // Ensure all queries successfully executed
    //         DB::beginTransaction();

    //         // Update client company
    //         StockInventory::where('id', $id)
    //             ->update([
    //                 'contractor_pic'        => $vendor,
    //                 'billboard_in_id'       => $billboard_in,
    //                 'billboard_out_id'      => $billboard_out,
    //                 'company_in_id'         => $client_in,
    //                 'company_out_id'        => $client_out,
    //                 'date_in'               => $date_in,
    //                 'date_out'              => $date_out,
    //                 'remarks_in'            => $remarks_in,
    //                 'remarks_out'           => $remarks_out,
    //                 'quantity_in'           => $quantity_in,
    //                 'quantity_out'          => $quantity_out,
    //             ]);

    //         // Ensure all queries successfully executed, commit the db changes
    //         DB::commit();

    //         return response()->json([
    //             "success"   => "success",
    //         ], 200);
    //     } catch (\Exception $e) {
    //         // If any queries fail, undo all changes
    //         DB::rollback();

    //         return response()->json(['error' => $e->getMessage()], 422);
    //     }
    // }

    public function edit($inventoryId)
    {
        $inventory = StockInventory::with('sites.billboard')->findOrFail($inventoryId);

        // Separate IN and OUT sites
        $sites_in  = $inventory->sites->where('type', 'in')->values();
        $sites_out = $inventory->sites->where('type', 'out')->values();

        return response()->json([
            'inventory' => $inventory,
            'sites_in'  => $sites_in,
            'sites_out' => $sites_out,
        ]);
    }


    /**
     * Delete client.
     */
    public function delete(Request $request)
    {

        $id = $request->id;

        logger('delete: ' . $id);

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'id' => [
                    'required',
                    'integer',
                    'exists:contractors,id',
                ],
            ],
            [
                'id.exists' => 'The contractor cannot be found.',
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
            Contractor::where('id', $id)->delete();

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
