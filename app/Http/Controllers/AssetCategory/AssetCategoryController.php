<?php

namespace App\Http\Controllers\AssetCategory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class AssetCategoryController extends Controller
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
     * Show the asset category page.
     */
    public function index()
    {

        $assetsCategory = AssetCategory::all();
        return view('assetCategory.index', compact('assetsCategory'));
    }

    /**
     * Show the asset category list.
     */
    public function list(Request $request)
    {
        // Set the time zone to Dubai
        $today = Carbon::today('Asia/Dubai');

        logger('heree');

        // $ustatus = $request->input('ustatus');
        $assetCategory = $request->input('assetcat');

        $columns = array(
            0 => 'code',
            1 => 'name',
            2 => 'description',
            3 => 'created_at',
            4 => 'updated_at',
            5 => 'id',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $columns[$orderColumnIndex];
        $orderDirection = $request->input('order.0.dir');

        $query = AssetCategory::select('id', 'code', 'name', 'description', 'created_at', 'updated_at')
        ->orderBy($orderColumnName, $orderDirection);


        // if ($ustatus == "0") {
        //     $query->where('vendors.user_id', null);
        // } elseif ($ustatus == "1"){
        //     $query->whereNotNull('vendors.user_id');
        // };

        if ($assetCategory != "") {
            $query->where('asset_category.id', $assetCategory);
        }

        // Get total records count
        $totalData = $query->count();

        $searchValue = trim(strtolower($request->input('search.value')));

        if (!empty($searchValue)) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('id', 'LIKE', "%{$searchValue}%")
                    ->orWhere('code', 'LIKE', "%{$searchValue}%")
                    ->orWhere('name', 'LIKE', "%{$searchValue}%");
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
                'id'                            => $d->id,
                'code'                          => $d->code,
                'name'                          => $d->name,
                'description'                   => $d->description,
                'created_at'                    => $d->created_at,
                'updated_at'                    => $d->updated_at,
            );
            $data[] = $nestedData;
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );

        logger($json_data);

        echo json_encode($json_data);
    }

    // /**
    //  * Create asset category.
    //  */
    public function create(Request $request)
    {
        $name       = $request->name;
        $code       = $request->code;
        $description    = $request->description;


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
                'code' => [
                    'required',
                    // 'regex:/^\+?[0-9]+$/',
                    'max:255',
                ],
                'description' => [
                    'required',
                ],
            ],
            [
                'name.required' => 'The "Vendor Name" field is required.',
                'name.string' => 'The "Vendor Name" must be a string.',
                'name.max' => 'The "Vendor Name" must not be greater than :max characters.',

                'code.required' => 'The "Contact No." field is required.',
                'code.regex' => 'The "Contact No." field must only contain "+" symbol and numbers.',
                'code.max' => 'The "Contact No." must not be greater than :max characters.',

                'description.required' => 'The "Vendor Company" field is required.',
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
            $assetCategory = AssetCategory::create([
                'name'               => $name,
                'code'               => $code,
                'description'        => $description,
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
    //  * Edit asset category.
    //  */
    public function edit(Request $request)
    {
        $id                     = $request->original_asset_category_id;

        $code               = $request->code;
        $name               = $request->name;
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
                ],
                'name' => [
                    'required',
                    // 'regex:/^\+?[0-9]+$/',
                    'max:255',
                ],
            ],
            [
                'code.required' => 'Code" field is required.',
                'code.string' => 'Code" must be a string.',
                'code.max' => 'Code" must not be greater than :max characters.',

                'name.required' => 'The "Asset Category Name" field is required.',
                // 'name.regex' => 'The "Contact No." field must only contain "+" symbol and numbers.',
                'name.max' => 'The "Asset Category Name" must not be greater than :max characters.',
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
            AssetCategory::where('id', $id)
                ->update([
                    'code'              => $code,
                    'name'              => $name,
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

    /**
     * Delete vendor.
     */
    public function delete(Request $request)
    {
        // Get the current UTC time
        $current_UTC = Carbon::now('UTC');

        $delete_assetCategory_id = $request->delete_assetCategory_id;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'delete_assetCategory_id' => [
                    'unique:assets,asset_category_id',
                ],
            ],
            [
                'delete_assetCategory_id.unique' => 'This cannot be deleted as assets is found associated with this asset category',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            AssetCategory::find($delete_assetCategory_id)->delete();
            
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