<?php

namespace App\Http\Controllers\Assets;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\PurchaseOrder;
use App\Models\Locations;
use App\Models\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class AssetsController extends Controller
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
     * Show the asset page.
     */
    public function index()
    {
        // if (is_null($this->user) || !$this->user->can('asset.view')) {
        //     abort(403, 'Sorry !! You are Unauthorized to view any vendor. Contact system admin for access !');
        // }

        $assetsCategory = AssetCategory::all();
        $purchaseOrder = PurchaseOrder::all();
        $buildings = Locations::where('type', 'building')->get();
        $levels = Locations::where('type', 'level')->get();
        $departments = Locations::where('type', 'department')->get();

        return view('assets.index', compact('assetsCategory', 'purchaseOrder', 'buildings', 'levels', 'departments'));
    }

    public function getLocation(Request $request)
    {
        $deptId = $request->input('dept_id');

        // Fetch dept for the selected dept
        $original_departments = Locations::where('id', $deptId)
        ->where('type', 'department')
        ->get();

        // Fetch levels for the selected dept
        $original_levels = Locations::where('id', $original_departments[0]->parent_id)
        ->where('type', 'level')
        ->get();

        // // Fetch building for the selected level
        $original_buildings = Locations::where('id', $original_levels[0]->parent_id)
        ->where('type', 'building')
        ->get();

        // Fetch building
        $buildings = Locations::where('type', 'building')
        ->get();

        // Fetch levels for the selected building
        $levels = Locations::where('parent_id', $original_buildings[0]->id)
        ->where('type', 'level')
        ->get();

        // Fetch dept for the selected level
        $departments = Locations::where('parent_id', $original_departments[0]->parent_id)
        ->where('type', 'department')
        ->get();

        $bldgs = array();
        $lvls = array();
        $depts = array();

        foreach ($buildings as $bldg) {

            $nestedData = array(
                'id'               => $bldg->id,
                'name'             => $bldg->name,
                'type'             => $bldg->type,
                'parent_id'        => $bldg->parent_id,
            );
            $bldgs[] = $nestedData;
        }

        foreach ($levels as $lvl) {

            $nestedData = array(
                'id'               => $lvl->id,
                'name'             => $lvl->name,
                'type'             => $lvl->type,
                'parent_id'        => $lvl->parent_id,
            );
            $lvls[] = $nestedData;
        }

        foreach ($departments as $dept) {

            $nestedData = array(
                'id'               => $dept->id,
                'name'             => $dept->name,
                'type'             => $dept->type,
                'parent_id'        => $dept->parent_id,
            );
            $depts[] = $nestedData;
        }

        // Prepare data to be returned
        $data = [
            'departments' => [],
            'levels' => [],
            'buildings' => [],
        ];

        foreach ($bldgs as $building) {
            $data['buildings'][] = [
                'id'        => $building['id'],
                'name'      => $building['name'],
                'type'      => $building['type'],
                'parent_id' => $building['parent_id'],
            ];
        }
        
        foreach ($lvls as $level) {
            $data['levels'][] = [
                'id'        => $level['id'],
                'name'      => $level['name'],
                'type'      => $level['type'],
                'parent_id' => $level['parent_id'],
            ];
        }
        
        foreach ($depts as $department) {
            $data['departments'][] = [
                'id'        => $department['id'],
                'name'      => $department['name'],
                'type'      => $department['type'],
                'parent_id' => $department['parent_id'],
            ];
        }

        return response()->json($data);
    }

    public function getLevels(Request $request)
    {
        $buildingId = $request->input('building_id');

        logger('buildingId: '. $buildingId);
        
        // Fetch levels for the selected building
        $levels = Locations::where('parent_id', $buildingId)
        ->where('type', 'level')
        ->get();

        logger('level: '. $levels);

        return response()->json($levels);
    }

    public function getDepartments(Request $request)
    {
        $levelId = $request->input('level_id');

        logger('levelId: '. $levelId);
        
        // Fetch dept for the selected level
        $depts = Locations::where('parent_id', $levelId)
        ->where('type', 'department')
        ->get();

        logger('depts: '. $depts);

        return response()->json($depts);
    }

    /**
     * Show the asset list.
     */
    public function list(Request $request)
    {
        // Set the time zone to Dubai
        $today = Carbon::today('Asia/Dubai');

        // $ustatus = $request->input('ustatus');
        $assetCategory = $request->input('assetcat');

        $columns = array(
            0 => 'code',
            1 => 'name',
            2 => 'asset_category',
            3 => 'asset_category_id',
            4 => 'description',
            5 => 'location_id',
            6 => 'location_name',
            7 => 'receipt_reference_number',
            8 => 'purchase_order_id',
            9 => 'id',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $columns[$orderColumnIndex];
        $orderDirection = $request->input('order.0.dir');

        $query = Asset::leftJoin('locations', 'locations.id', '=', 'assets.location_id')
            ->leftJoin('purchase_orders', 'purchase_orders.id', '=', 'assets.purchase_order_id')
            ->leftJoin('asset_category', 'asset_category.id', '=', 'assets.asset_category_id')
            ->select('assets.id', 'assets.code', 'assets.name', DB::raw("CONCAT(asset_category.code, ' - ', asset_category.name) AS asset_category"), 'assets.asset_category_id', 'purchase_orders.id as purchase_order_id', 'assets.description', 'locations.id as location_id', 'locations.name as location_name', 'purchase_orders.receipt_reference_number');    

        $query->orderBy($orderColumnName, $orderDirection);

        if ($assetCategory != "") {
            $query->where('asset_category.id', $assetCategory);
        }

        // Get total records count
        $totalData = $query->count();

        $searchValue = trim(strtolower($request->input('search.value')));

        if (!empty($searchValue)) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('assets.code', 'LIKE', "%{$searchValue}%")
                    ->orWhere('assets.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('asset_category.code', 'LIKE', "%{$searchValue}%")
                    ->orWhere('asset_category.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('locations.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('purchase_orders.receipt_reference_number', 'LIKE', "%{$searchValue}%");
            });
        }

        // Get total filtered records count
        $totalFiltered = $query->count();

        // Apply pagination
        $filteredData = $query->skip($start)->take($limit)->get();

        $data = array();

        foreach ($filteredData as $d) {

            $nestedData = array(
                'code'                          => $d->code,
                'name'                          => $d->name,
                'asset_category'                => $d->asset_category,
                'asset_category_id'             => $d->asset_category_id,
                'description'                   => $d->description,
                'location_id'                   => $d->location_id,
                'location_name'                 => $d->location_name,
                'receipt_reference_number'      => $d->receipt_reference_number,
                'purchase_order_id'             => $d->purchase_order_id,
                'id'                            => $d->id,
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
    //  * Create asset.
    //  */
    public function create(Request $request)
    {
        $code                   = $request->code;
        $name                   = $request->name;
        $asset_category_id      = $request->asset_category_id;
        $desc                   = $request->desc;
        $dept                   = $request->dept;
        $purchase_order_id      = $request->purchase_order_id;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'code' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'asset_category_id' => [
                    'required',
                ],
                'desc' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'dept' => [
                    'required',
                ],
                'purchase_order_id' => [
                    'required',
                ],
            ],
            [
                'code.required' => 'The "Asset Code" field is required.',
                'code.string' => 'The "Asset Code" must be a string.',
                'code.max' => 'The "Asset Code" must not be greater than :max characters.',

                'name.required' => 'The "Asset Name" field is required.',
                'name.string' => 'The "Asset Name" must be a string.',
                'name.max' => 'The "Asset Name" must not be greater than :max characters.',

                'asset_category_id.required' => 'The "Asset Category" field is required.',

                'desc.required' => 'The "Description" field is required.',
                'desc.string' => 'The "Description" must be a string.',
                'desc.max' => 'The "Description" must not be greater than :max characters.',

                'dept.required' => 'The "Department" field is required.',

                'purchase_order_id.required' => 'The "Purchase Order Receipt Reference ID" field is required.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Insert new asset
            $asset = Asset::create([
                'code'                  => $code,
                'name'                  => $name,
                'asset_category_id'     => $asset_category_id,
                'description'           => $desc,
                'location_id'           => $dept,
                'purchase_order_id'     => $purchase_order_id,
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
    //  * Edit asset.
    //  */
    public function edit(Request $request)
    {
        $id                     = $request->original_asset_id;
        $code                   = $request->code;
        $name                   = $request->name;
        $asset_category_id      = $request->asset_category_id;
        $desc                   = $request->desc;
        $building               = $request->building;
        $level                  = $request->level;
        $dept                   = $request->dept;
        $purchase_order_id      = $request->purchase_order_id;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'code' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'asset_category_id' => [
                    'required',
                ],
                'desc' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'building' => [
                    'required',
                ],
                'level' => [
                    'required',
                ],
                'dept' => [
                    'required',
                ],
                'purchase_order_id' => [
                    'required',
                ],
            ],
            [
                'code.required' => 'The "Asset Code" field is required.',
                'code.string' => 'The "Asset Code" must be a string.',
                'code.max' => 'The "Asset Code" must not be greater than :max characters.',

                'name.required' => 'The "Asset Name" field is required.',
                'name.string' => 'The "Asset Name" must be a string.',
                'name.max' => 'The "Asset Name" must not be greater than :max characters.',

                'asset_category_id.required' => 'The "Asset Category" field is required.',

                'desc.required' => 'The "Description" field is required.',
                'desc.string' => 'The "Description" must be a string.',
                'desc.max' => 'The "Description" must not be greater than :max characters.',

                'building.required' => 'The "Building" field is required.',

                'level.required' => 'The "Level" field is required.',

                'dept.required' => 'The "Department" field is required.',

                'purchase_order_id.required' => 'The "Purchase Order Receipt Reference ID" field is required.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Update asset
            Asset::where('id', $id)
                ->update([
                    'code'                  => $code,
                    'name'                  => $name,
                    'asset_category_id'     => $asset_category_id,
                    'description'           => $desc,
                    'location_id'           => $dept,
                    'purchase_order_id'     => $purchase_order_id,
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
     * Delete asset.
     */
    public function delete(Request $request)
    {
        // Get the current UTC time
        $current_UTC = Carbon::now('UTC');

        $delete_asset_id = $request->delete_asset_id;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'delete_asset_id' => [
                    'unique:service_request,asset_id',
                ],
            ],
            [
                'delete_asset_id.unique' => 'This cannot be deleted as service request is found associated with this purchase order',
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

            Asset::find($delete_asset_id)->delete();
            
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