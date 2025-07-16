<?php

namespace App\Http\Controllers\Projects;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ClientCompany;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

class ProjectsController extends Controller
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
     * Show the projects page.
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('project.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any project. Contact system admin for access !');
        }
        // $type = Project::distinct()->get(['type']);
        // return view('projects.index', compact('type'));

        $clientcompany = ClientCompany::orderBy('name', 'ASC')->get();
        $projects = Project::all();

        return view('projects.index', compact('clientcompany', 'projects'));
    }

    /**
     * Show the projects list.
     */
    public function list(Request $request)
    {
        // Set the time zone to Dubai
        $today = Carbon::today('Asia/Dubai');

        $company = $request->input('company');
        $type = $request->input('type');

        $columns = array(
            0 => 'project_prefix',
            1 => 'from_date',
            2 => 'to_date',
            3 => 'type',
            4 => 'client_company_name',
            5 => 'created_at',
            6 => 'id',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $columns[$orderColumnIndex];
        $orderDirection = $request->input('order.0.dir');

        $query = Project::leftJoin('client_company', 'client_company.id', '=', 'projects.client_company_id')
            ->select('projects.id as project_id', 'projects.project_prefix as project_prefix', 'projects.from_date as from_date', 'projects.to_date as to_date', 'projects.type as type', 'client_company.name as client_company_name', 'projects.created_at as created_at')
            ->where('status', '1')
            ->orderBy($orderColumnName, $orderDirection);

        if ($type != "all") {
            $query->where('projects.type', $type);
        }

        if ($company != "all") {
            $query->where('client_company.id', $company);
        }

        // Get total records count
        $totalData = $query->count();

        $searchValue = trim(strtolower($request->input('search.value')));

        if (!empty($searchValue)) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('projects.project_prefix', 'LIKE', "%{$searchValue}%")
                    ->orWhere('client_company.name', 'LIKE', "%{$searchValue}%");
            });
        }

        // Get total filtered records count
        $totalFiltered = $query->count();

        // Apply pagination
        $filteredData = $query->skip($start)->take($limit)->get();

        $data = array();

        foreach ($filteredData as $d) {
            $project_status = ($d->from_date <= $today && $d->to_date >= $today) ? 'Active' : 'Inactive';
            $created_at = Carbon::parse($d->created_at)->format('Y-m-d H:i:s');
            $from_date = Carbon::parse($d->from_date)->format('d M, Y');
            $to_date = Carbon::parse($d->to_date)->format('d M, Y');

            $nestedData = array(
                'id'                => $d->project_id,
                'project_prefix'   => $d->project_prefix,
                'from_date'         => $from_date,
                'to_date'           => $to_date,
                'type'              => $d->type,
                'client_company_name' => $d->client_company_name,
                'created_at'        => $created_at,
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
     * Create projects.
     */
    public function create(Request $request)
    {
        $project_prefix    = $request->project_prefix;
        $type               = $request->type;
        $client_company_id  = $request->client_company_id;

        $from_date = explode(' - ', $request->from_to_date)[0];
        $to_date = explode(' - ', $request->from_to_date)[1];

        $carbonFormat = 'd M, Y';
        $from_date = \Carbon\Carbon::createFromFormat($carbonFormat, $from_date)->format('Y-m-d');
        $to_date = \Carbon\Carbon::createFromFormat($carbonFormat, $to_date)->format('Y-m-d');


        // Validation rules
        $rules = [
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ];

        // Custom error messages
        $messages = [
            'to_date.after_or_equal' => 'The "To Date" must be equal to or after the "From Date".',
        ];

        // Creating the validator instance
        $date_validator = Validator::make([
            'from_date' => $from_date,
            'to_date' => $to_date,
        ], $rules, $messages);



        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'project_prefix' => [
                    'required',
                    'string',
                    'max:4',
                    'unique:projects,project_prefix',
                    'regex:/^\S*$/', // No spaces allowed
                ],
                'type' => [
                    'required',
                ],
                'client_company_id' => [
                    'required',
                    // 'max:255',
                ],
            ],
            [
                'prefix.required' => 'The "Project Prefix" field is required.',
                'prefix.string' => 'The "Project Prefix" must be a string.',
                'prefix.max' => 'The "Project Prefix" must not be greater than :max characters.',
                'prefix.unique' => 'The "Project Prefix" is already been taken.',
                'prefix.regex' => 'The "Project Prefix" must not contain any spaces.',

                'type.required' => 'The "Type" field is required.',

                'client_company_id.required' => 'The "Client Company Id" field is required.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        } else if ($date_validator->fails()) {
            return response()->json(['error' => $date_validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Insert new projects
            $user = Project::create([
                'project_prefix'        => $project_prefix,
                'from_date'              => $from_date,
                'to_date'                => $to_date,
                'type'                   => $type,
                'client_company_id'      => $client_company_id,

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
     * Edit projects.
     */
    public function edit(Request $request)
    {
        
        $project_prefix        = $request->project_prefix;
        $type                   = $request->type;
        $original_project_id   = $request->original_project_id;

        $from_date = explode(' - ', $request->from_to_date)[0];
        $to_date = explode(' - ', $request->from_to_date)[1];


        $carbonFormat = 'd M, Y';
        $from_date = \Carbon\Carbon::createFromFormat($carbonFormat, $from_date)->format('Y-m-d');
        $to_date = \Carbon\Carbon::createFromFormat($carbonFormat, $to_date)->format('Y-m-d');


        
        // Validation rules
        $rules = [
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ];

        // Custom error messages
        $messages = [
            'to_date.after_or_equal' => 'The "To Date" must be equal to or after the "From Date".',
        ];

        // Creating the validator instance
        $date_validator = Validator::make([
            'from_date' => $from_date,
            'to_date' => $to_date,
        ], $rules, $messages);
        
        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'project_prefix' => [
                    'required',
                    'string',
                    'max:4',
                    // 'unique:projects,project_prefix',
                    Rule::unique('projects', 'project_prefix')->ignore($original_project_id), // Exclude original value but still checks for uniqueness
                    'regex:/^\S*$/', // No spaces allowed
                ],
                'type' => [
                    'required',
                    // 'string',
                    // 'unique:projects,type',
                    // 'max:255',
                ]
            ],
            [
                'project_prefix.required' => 'The "Project Prefix" field is required.',
                'project_prefix.string' => 'The "Project Prefix" must be a string.',
                'project_prefix.max' => 'The "Project Prefix" must not be greater than :max characters.',
                'project_prefix.unique' => 'The "Project Prefix" is already been taken.',
                'project_prefix.regex' => 'The "Project Prefix" must not contain any spaces.',

                'type.required' => 'The "Type" field is required.',
            ]
        );

        // Handle failed validations
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            // Update projects
            Project::where('id', $original_project_id)
                ->update([
                    'project_prefix'       => $project_prefix,
                    'from_date'             => $from_date,
                    'to_date'               => $to_date,
                    'type'                  => $type,
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
     * Delete projects.
     */
    public function delete(Request $request)
    {
        // Get the current UTC time
        $current_UTC = Carbon::now('UTC');

        $delete_project_id = $request->delete_project_id;

        // Validate fields
        $validator = Validator::make(
            $request->all(),
            [
                'delete_project_id' => [
                    'required',
                    'integer',
                    'exists:projects,id',
                ],
            ],
            [
                'delete_project_id.exists' => 'The projects cannot be found.',
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
            Project::where('id', $delete_project_id)
                ->delete();

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
