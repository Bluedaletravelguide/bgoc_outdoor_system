<?php

namespace App\Http\Controllers\Locations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Locations;
use App\Models\ProjectHasLocations;
use App\Models\ClientCompany;
use App\Models\Contract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class LocationsController extends Controller
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

    public function index()
    {
        $locations = Locations::orderBy('name')->where('type', 'building')->whereNull('parent_id')->get()->groupBy(function ($item) {
            return substr($item->name, 0, 1);
        });

        $firstBuildingId = Locations::select('id')->orderBy('name')->where('type', 'building')->whereNull('parent_id')->first();

        $clientCompanies = ClientCompany::select('client_company.id', 'client_company.name')
            ->leftJoin('contracts', 'contracts.client_company_id', '=', 'client_company.id')
            ->where('client_company.status', '1')
            ->where('contracts.type', 'open')
            ->whereNotNull('contracts.id')
            ->distinct()
            ->get();

        return view('locations.index', [
            'locations' => $locations,
            'firstBuildingId' => $firstBuildingId->id,
            'clientCompanies' => $clientCompanies,
        ]);
    }

    public function buildingList(Request $request)
    {
        $building_id = $request->building_id;

        $columns = array(
            0 => 'level_name',
            1 => 'department_name',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir');

        $query = Locations::selectRaw('locations.id AS location_id, locations.name, locations.created_at, locations.updated_at, levels.id AS level_id, levels.name AS level_name, departments.id AS department_id, departments.name AS department_name')
            ->leftJoin('locations AS levels', 'levels.parent_id', '=', 'locations.id')
            ->leftJoin('locations AS departments', 'departments.parent_id', '=', 'levels.id')
            ->where('locations.id', $building_id)
            ->whereNull('locations.parent_id');

        $searchValue = trim(strtolower($request->input('search.value')));

        // Apply search if applicable
        if (!empty($searchValue)) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('levels.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('departments.name', 'LIKE', "%{$searchValue}%");
            });
        }

        // Apply sorting if applicable
        if (isset($columns[$orderColumnIndex])) {
            $query->orderBy($columns[$orderColumnIndex], $orderDirection);
        }

        // Execute the query
        $organizations = $query->get();

        $groupedData = $organizations->groupBy('level_id')->map(function ($items) {
            return $items->pluck('department_id')->toArray();
        });

        // Get a portion of the grouped data based on pagination parameters
        $slicedData = $groupedData->slice($start, $limit);

        $finalData = [];
        foreach ($slicedData as $parentName => $locations) {
            $parentLocationName = $organizations->firstWhere('level_id', $parentName)->level_name ?? null;
            $levelId = $organizations->firstWhere('level_id', $parentName)->level_id ?? null;

            $locationDetails = [];
            foreach ($locations as $location) {
                $floorName = $organizations->firstWhere('department_id', $location)->department_name ?? null;

                $locationDetails[] = [
                    'id' => $location,
                    'name' => $floorName,
                ];
            }

            // Filter out null values in locationDetails
            $locationDetails = array_filter($locationDetails, function ($detail) {
                return !is_null($detail['id']) && !is_null($detail['name']);
            });

            // Check if parentLocationName, levelId, and locationDetails are not all null
            if (!is_null($parentLocationName) || !is_null($levelId) || !empty($locationDetails)) {
                $finalData[] = [
                    'parent_location_name' => $parentLocationName,
                    'location_details' => $locationDetails,
                    'level_id' => $levelId,
                ];
            }
        }

        // Preparing the JSON response
        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => count($groupedData),
            "recordsFiltered" => count($groupedData), // This might not reflect actual filtered count due to post-processing
            "data" => $finalData,
        ];

        return response()->json($json_data);
    }

    public function buildingDetails(Request $request)
    {
        $building_id = $request->building_id;

        $buildingDetails = Locations::selectRaw('locations.name AS building_name, contracts.contract_prefix, client_company.name AS client_company_name')
            ->leftJoin('project_has_locations', 'project_has_locations.location_id', '=', 'locations.id')
            ->leftJoin('contracts', 'contracts.id', '=', 'project_has_locations.contract_id')
            ->leftJoin('client_company', 'client_company.id', '=', 'contracts.client_company_id')
            ->where('locations.id', $building_id)
            ->first();

        return response()->json([
            "data" => $buildingDetails,
            "success" => "success",
        ], 200);
    }

    public function buildingStore(Request $request)
    {
        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'addClientCompanyInput' => [
                    'required',
                    'exists:client_company,id',
                ],
                'addBuildingName' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'addLevelInput' => [
                    'required', // The addLevelInput array itself must be present and not empty
                    'array',    // Ensures the input is an array
                ],
                'addLevelInput.*' => [
                    'filled', // Each addLevelInput must not be empty
                    'string',
                    'max:255',
                ],
            ],
            [
                'addClientCompanyInput.required' => 'The "Client Company" field is required.',
                'addClientCompanyInput.exists' => 'The "Client Company" cannot be found in system.',

                'addBuildingName.required' => 'The "Building Name" field is required.',
                'addBuildingName.string' => 'The "Building Name" field must be a string.',
                'addBuildingName.max' => 'The "Building Name" field must not be greater than :max characters.',

                'addLevelInput.required' => 'At least one "Level Name" field is required.',
                'addLevelInput.array' => 'The level needs to be an array.',

                'addLevelInput.*.filled' => 'The "Level Name" field must have a value.',
                'addLevelInput.*.string' => 'The "Level Name" field must be a string.',
                'addLevelInput.*.max' => 'The "Level Name" field must not be greater than :max characters.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            $building_name = $request->addBuildingName;
            $levels   = $request->addLevelInput;
            $client_company_id   = $request->addClientCompanyInput;

            // Retrieve contract
            $contract = Contract::where('type', 'open')->where('client_company_id', $client_company_id)->first();

            // Add new building into locations table
            $building = Locations::create([
                'name' => $building_name,
                'type' => 'building',
            ]);

            // Add levels into locations table
            foreach ($levels as $level) {
                Locations::create([
                    'name' => $level,
                    'type' => 'level',
                    'parent_id' => $building->id,
                ]);
            }

            // Add Project Has Locations
            ProjectHasLocations::create([
                'contract_id' => $contract->id,
                'location_id' => $building->id,
            ]);

            // Commit the transaction if everything is successful
            DB::commit();
            return redirect()->back()->with('success', 'New building added successfully.');
        } catch (QueryException $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function buildingUpdate(Request $request)
    {
        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'editBuildingId' => [
                    'required',
                    'exists:locations,id',
                ],
                'editBuildingName' => [
                    'required',
                    'string',
                    'max:255',
                ],
            ],
            [
                'editBuildingId.required' => 'The "Building ID" field is required.',
                'editBuildingId.exists' => 'The "Building ID" cannot be found in system.',

                'editBuildingName.required' => 'The "Building Name" field is required.',
                'editBuildingName.string' => 'The "Building Name" field must be a string.',
                'editBuildingName.max' => 'The "Building Name" field must not be greater than :max characters.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            $edit_building_id = $request->editBuildingId;
            $edit_building_name = $request->editBuildingName;

            Locations::where('id', $edit_building_id)->update(['name' => $edit_building_name]);

            // Commit the transaction if everything is successful
            DB::commit();
            return redirect()->back()->with('success', 'Building edited successfully.');
        } catch (QueryException $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function buildingDelete(Request $request)
    {
        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'deleteBuildingId' => [
                    'required',
                    'exists:locations,id',
                ],
            ],
            [
                'deleteBuildingId.required' => 'The "Building ID" field is required.',
                'deleteBuildingId.exists' => 'The "Building ID" cannot be found in system.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            $delete_building_id = $request->deleteBuildingId;

            Locations::where('id', $delete_building_id)->delete();

            // Commit the transaction if everything is successful
            DB::commit();
            return redirect()->back()->with('success', 'Building deleted successfully.');
        } catch (QueryException $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function levelStore(Request $request)
    {
        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'addLevelBuildingId' => [
                    'required',
                    'exists:locations,id',
                ],
                'addLevelName' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'addDepartmentInput' => [
                    'required', // The addDepartmentInput array itself must be present and not empty
                    'array',    // Ensures the input is an array
                ],
                'addDepartmentInput.*' => [
                    'filled', // Each addDepartmentInput must not be empty
                    'string',
                    'max:255',
                ],
            ],
            [
                'addLevelBuildingId.required' => 'The "Building ID" field is required.',
                'addLevelBuildingId.exists' => 'The "Building ID" cannot be found in system.',

                'addLevelName.required' => 'The "Level Name" field is required.',
                'addLevelName.string' => 'The "Level Name" field must be a string.',
                'addLevelName.max' => 'The "Level Name" field must not be greater than :max characters.',

                'addDepartmentInput.required' => 'At least one "Department Name" field is required.',
                'addDepartmentInput.array' => 'The department needs to be an array.',

                'addDepartmentInput.*.filled' => 'The "Department Name" field must have a value.',
                'addDepartmentInput.*.string' => 'The "Department Name" field must be a string.',
                'addDepartmentInput.*.max' => 'The "Department Name" field must not be greater than :max characters.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            $level_name = $request->addLevelName;
            $departments = $request->addDepartmentInput;
            $building_id = $request->addLevelBuildingId;

            // Add new level into locations table
            $level = Locations::create([
                'name' => $level_name,
                'type' => 'level',
                'parent_id' => $building_id,
            ]);

            // Add departments into locations table
            foreach ($departments as $department) {
                Locations::create([
                    'name' => $department,
                    'type' => 'department',
                    'parent_id' => $level->id,
                ]);
            }

            // Commit the transaction if everything is successful
            DB::commit();
            return redirect()->back()->with('success', 'New level added successfully.');
        } catch (QueryException $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function levelUpdate(Request $request)
    {
        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'editLevelId' => [
                    'required',
                    'integer',
                    'exists:locations,id',
                ],
                'editLevelName' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'editExistingDepartmentNameInput' => [
                    'array',    // Ensures the input is an array
                ],
                'editExistingDepartmentIdInput' => [
                    'array',    // Ensures the input is an array
                ],
                'editNewDepartmentNameInput.*' => [
                    'filled', // Each new department must not be empty
                    'string',
                    'max:255',
                ],
            ],
            [
                'editLevelId.required' => 'The "Level ID" cannot be found.',
                'editLevelId.integer' => 'The "Level ID" cannot be found.',
                'editLevelId.exists' => 'The "Level ID" cannot be found.',

                'editLevelName.required' => 'The "Level Name" field is required.',
                'editLevelName.string' => 'The "Level Name" field must be a string.',
                'editLevelName.max' => 'The "Level Name" field must not be greater than :max characters.',

                'editExistingDepartmentNameInput.*.required' => 'The existing "Department Name" field must not be empty.',
                'editExistingDepartmentNameInput.*.array' => 'The department needs to be an array.',
                'editExistingDepartmentNameInput.*.name.filled' => 'The "Department Name" field must have a value.',
                'editExistingDepartmentNameInput.*.name.string' => 'The "Department Name" field must be a string.',
                'editExistingDepartmentNameInput.*.name.max' => 'The "Department Name" field must not be greater than :max characters.',

                'editExistingDepartmentIdInput.*.required' => 'The existing "Department ID" field must not be empty.',
                'editExistingDepartmentIdInput.*.array' => 'The department id needs to be an array.',
                'editExistingDepartmentIdInput.*.name.filled' => 'The "Department ID" field must have a value.',
                'editExistingDepartmentIdInput.*.name.string' => 'The "Department ID" field must be a string.',
                'editExistingDepartmentIdInput.*.name.max' => 'The "Department ID" field must not be greater than :max characters.',

                'editNewDepartmentNameInput.*.filled' => 'The "Department Name" field must have a value.',
                'editNewDepartmentNameInput.*.string' => 'The "Department Name" field must be a string.',
                'editNewDepartmentNameInput.*.max' => 'The "Department Name" field must not be greater than :max characters.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            $original_level_id      = $request->editLevelId;
            $level_name             = $request->editLevelName;
            $new_departments        = $request->editNewDepartmentNameInput;

            $department_ids = $request->editExistingDepartmentIdInput;
            $department_names = $request->editExistingDepartmentNameInput;

            $departments = [];

            // Check if the array is present
            if (is_array($department_ids) && is_array($department_names)) {
                for ($i = 0; $i < count($department_ids); $i++) {
                    $departments[] = [
                        'id' => $department_ids[$i],
                        'name' => $department_names[$i]
                    ];
                }

                foreach ($departments as $department) {
                    Locations::where('id', $department['id'])->update(['name' => $department['name']]);
                }
            }

            // Create new departments
            if ($new_departments) {
                foreach ($new_departments as $department) {
                    Locations::create([
                        'name'      => $department,
                        'parent_id' => $original_level_id,
                        'type' => 'department',
                    ]);
                }
            }

            // Update level name
            Locations::where('id', $original_level_id)->update(['name' => $level_name]);

            // Ensure all queries successfully executed, commit the db changes
            DB::commit();

            return redirect()->back()->with('success', 'Level and departments edited successfully.');
        } catch (\Exception $e) {
            // If any queries fail, undo all changes
            DB::rollback();

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function levelDelete(Request $request)
    {
        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'deleteLevelId' => [
                    'required',
                    'exists:locations,id',
                ],
            ],
            [
                'deleteLevelId.required' => 'The "Level ID" field is required.',
                'deleteLevelId.exists' => 'The "Level ID" cannot be found in system.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            $delete_level_id = $request->deleteLevelId;

            Locations::where('id', $delete_level_id)->delete();

            // Commit the transaction if everything is successful
            DB::commit();
            return redirect()->back()->with('success', 'Level deleted successfully.');
        } catch (QueryException $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function departmentDelete(Request $request)
    {
        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'deleteDepartmentId' => [
                    'required',
                    'exists:locations,id',
                ],
            ],
            [
                'deleteDepartmentId.required' => 'The "Department ID" field is required.',
                'deleteDepartmentId.exists' => 'The "Department ID" cannot be found in system.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            $delete_department_id = $request->deleteDepartmentId;

            Locations::where('id', $delete_department_id)->delete();

            // Commit the transaction if everything is successful
            DB::commit();
            return redirect()->back()->with('success', 'Department deleted successfully.');
        } catch (QueryException $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
