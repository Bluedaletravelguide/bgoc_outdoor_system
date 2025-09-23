<?php

namespace App\Http\Controllers\Billboard;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\ClientCompany;
use App\Models\User;
use App\Models\Billboard;
use App\Models\BillboardImage;
use App\Models\Contractor;
use App\Models\State;
use App\Models\District;
use App\Models\Council;
use App\Models\Location;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PushNotificationController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use App\Exports\BillboardExport;
use Maatwebsite\Excel\Facades\Excel;

class BillboardController extends Controller
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
        if (is_null($this->user) || !$this->user->can('billboard.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any project. Contact system admin for access !');
        }
        // $type = Project::distinct()->get(['type']);
        // return view('projects.index', compact('type'));

        $states = State::orderBy('name', 'ASC')->get();
        $districts = District::orderBy('name', 'ASC')->get();
        $locations = Location::orderBy('name', 'ASC')->get();
        $billboardTypes = Billboard::select('type', 'prefix')->distinct()->pluck('type', 'prefix');
        $billboardStatus = Billboard::distinct()->pluck('status');
        $billboardSize = Billboard::distinct()->pluck('size');
        $billboardLighting = Billboard::distinct()->pluck('lighting');
        $billboards = Billboard::leftJoin('locations', 'billboards.location_id', '=', 'locations.id')->get();

        $contractors = Contractor::all();
        $clientcompany = ClientCompany::all();

        // return view('workOrder.index', compact('clientcompany', 'projects', 'supervisors', 'technicians'));
        return view('billboard.index', compact('states', 'districts', 'locations', 'billboardTypes', 'billboardStatus', 'billboardSize', 'billboardLighting', 'contractors',
        'clientcompany', 'billboards'));
    }

    /**
     * Show the on going work order list.
     */
    public function list(Request $request)
    {
        $user = Auth::user();

        // Get user roles
        $role = $user->roles->pluck('name')[0];

        $userID = $this->user->id;

        $status = $request->input('status');
        $state = $request->input('state');
        $district = $request->input('district');
        $type     = $request->input('type');
        $site_type     = $request->input('site_type');
        $size     = $request->input('size');
        
        $columns = array(
            0 => 'site_number',
            1 => 'type',
            2 => 'size',
            3 => 'lighting',
            4 => 'location_name',
            5 => 'district_name',
            6 => 'date_registered',
            7 => 'status',
            8 => 'id',
            9 => 'site_type',
        );

        $limit              = $request->input('length');
        $start              = $request->input('start');
        $orderColumnIndex   = $request->input('order.0.column');
        $orderColumnName    = $columns[$orderColumnIndex];
        $orderDirection     = $request->input('order.0.dir');

        $query = Billboard::select('billboards.*', 'locations.id as location_id', 'locations.council_id as council_id', 'locations.name as location_name', 'districts.id as district_id', 'districts.name as district_name', 'states.id as state_id', 'states.name as state_name')
            ->leftJoin('locations', 'billboards.location_id', '=', 'locations.id')
            ->leftJoin('districts', 'locations.district_id', '=', 'districts.id')
            ->leftJoin('councils', 'councils.id', '=', 'locations.council_id')
            ->leftJoin('states', 'districts.state_id', '=', 'states.id')
            ->orderBy($orderColumnName, $orderDirection)
            ->orderBy('billboards.id', 'desc');

        if ($status != "all") {
            $query->where('billboards.status', $status);
        }

        if ($state != "all") {
            $query->where('states.id', $state);
        }

        if ($district != "all") {
            $query->where('districts.id', $district);
        }

        if ($type != "all") {
            $query->where('billboards.type', $type);
        }

        if ($site_type != "all") {
            $query->where('billboards.site_type', $site_type);
        }

        if ($size != "all") {
            $query->where('billboards.size', $size);
        }

        // Get total records count
        $totalData = $query->count();

        $searchValue = trim(strtolower($request->input('search.value')));

        if (!empty($searchValue)) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('billboards.site_number', 'LIKE', "%{$searchValue}%")
                ->orWhere('locations.name', 'LIKE', "%{$searchValue}%")
                ->orWhere('districts.name', 'LIKE', "%{$searchValue}%")
                ->orWhere('states.name', 'LIKE', "%{$searchValue}%");
            });
        }

        // Get total filtered records count
        $totalFiltered = $query->count();

        // Apply pagination
        if ($limit == -1) {
            // Export: get all filtered data (no pagination)
            $filteredData = $query->get();
        } else {
            // Normal request: paginate
            $filteredData = $query->skip($start)->take($limit)->get();
        }

        $data = array();

        foreach ($filteredData as $d) {
            $created_at = Carbon::parse($d->start_date)->format('d/m/y');

            $nestedData = array(
                'site_number'           => $d->site_number,
                'site_type'             => $d->site_type,
                'type'                  => $d->type, // display name
                'type_prefix'           => $d->prefix,
                'size'                  => $d->size,
                'lighting'              => $d->lighting,
                'location_id'           => $d->location_id,
                'state_id'              => $d->state_id,
                'district_id'           => $d->district_id,
                'council_id'            => $d->council_id,
                'location_name'         => $d->location_name,
                'region'                => $d->district_name . ', ' . $d->state_name,
                'gps_latitude'          => $d->gps_latitude,
                'gps_longitude'         => $d->gps_longitude,
                'traffic_volume'        => $d->traffic_volume,
                'status'                => $d->status,
                'created_at'            => $created_at,
                'status'                => $d->status,
                'id'                    => $d->id,
            );

            $data[] = $nestedData;
        }

        

        $json_data = array(
            "draw"              => intval($request->input('draw')),
            "recordsTotal"      => intval($totalData),
            "recordsFiltered"   => intval($totalFiltered),
            "data"              => $data,
        );

        return response()->json($json_data);
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $userID = $user->id;

        // ✅ Validation
        $validated = Validator::make($request->all(), [
            'type'          => 'required|string',
            'size'          => 'required|string|max:50',
            'lighting'      => 'required|string',
            'state'         => 'required|exists:states,id',
            'district'      => 'nullable|exists:districts,id',
            'council'       => 'required|exists:councils,id',
            'location'      => 'required|string|max:255',
            'land'          => 'required|string|max:10',
            'gpsCoordinate' => [
                'required',
                'regex:/^-?([0-8]?\d(\.\d+)?|90(\.0+)?),\s*-?(1[0-7]\d(\.\d+)?|180(\.0+)?)$/'
            ],
            'trafficvolume' => 'nullable|integer|min:0',
            'siteType' => 'nullable|string|max:10',
        ]);

        if ($validated->fails()) {
            return response()->json(['error' => $validated->errors()->first()], 422);
        }

        DB::beginTransaction();

        try {
            $type           = $request->type;
            $size           = $request->size;
            $lighting       = $request->lighting;
            $state          = $request->state;
            $district       = $request->district;
            $council        = $request->council;
            $locationName   = $request->location;
            $land           = $request->land;
            $trafficvolume  = $request->trafficvolume;
            $siteType       = $request->siteType;

            $coords = explode(',', $request->gpsCoordinate);
            $gpslatitude = trim($coords[0]);
            $gpslongitude = trim($coords[1]);

            // Step 1: Ensure location exists (or create new)
            $location = Location::firstOrCreate([
                'name'        => $locationName,
                'district_id' => $district,
                'council_id'  => $council,
            ]);

            // Step 2: Fetch state code
            $stateCode = State::select('prefix')->where('id', $state)->firstOrFail();

            // Step 3: Running number
            $lastBillboard = Billboard::whereHas('location.district.state', function ($query) use ($state) {
                    $query->where('id', $state);
                })
                ->orderBy('id', 'desc')
                ->lockForUpdate()
                ->first();

            if ($lastBillboard) {
                preg_match('/-(\d{4})-/', $lastBillboard->site_number, $matches);
                $lastNumber = isset($matches[1]) ? (int)$matches[1] : 0;
                $runningNumber = $lastNumber + 1;
            } else {
                $runningNumber = 1;
            }

            $formattedNumber = str_pad($runningNumber, 4, '0', STR_PAD_LEFT);
            $councilAbbv = Council::findOrFail($council)->abbreviation;

            // Step 4: Generate site_number
            $siteNumber = "{$type}-{$stateCode->prefix}-{$formattedNumber}-{$councilAbbv}-{$land}";

            $typeMap = [
                'BB' => 'Billboard',
                'TB' => 'Tempboard',
                'BU' => 'Bunting',
                'BN' => 'Banner',
            ];

            $prefix = $request->type;                // e.g. "TB"
            $type   = $typeMap[$prefix] ?? $prefix;  // e.g. "Tempboard"

            // Step 5: Create billboard
            $billboard = Billboard::create([
                'site_number'       => $siteNumber,
                'status'            => 1,
                'type'              => $type,
                'prefix'            => $prefix,
                'size'              => $size,
                'lighting'          => $lighting,
                'state'             => $state,
                'district'          => $district,
                'location_id'       => $location->id,
                'gps_longitude'     => $gpslongitude,
                'gps_latitude'      => $gpslatitude,
                'traffic_volume'    => $trafficvolume ?? 0,
                'site_type'          => $siteType,
                'created_by'        => $userID,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Billboard created successfully.',
                'billboard_id' => $billboard->id,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }


    /**
     * Update status of billboard
     */
    public function update(Request $request)
    {
        $billboard = Billboard::find($request->id);

        if (!$billboard) {
            return response()->json([
                'success' => false,
                'message' => 'Billboard not found.'
            ], 404);
        }

        // validate (you can adjust rules)
        $request->validate([
            'id' => 'required|integer|exists:billboards,id',
            'type' => 'required|string|max:255',
            'size' => 'nullable|string|max:255',
            'lighting' => 'nullable|string|max:255',
            'state_id' => 'nullable|integer',
            'district_id' => 'nullable|integer',
            'location_name' => 'nullable|string|max:255',
            'gpsCoordinate' => [
                'required',
                'regex:/^-?([0-8]?\d(\.\d+)?|90(\.0+)?),\s*-?(1[0-7]\d(\.\d+)?|180(\.0+)?)$/'
            ],
            'traffic_volume' => 'nullable|integer',
            'status' => 'nullable|integer',
            'site_type' => 'nullable|string|max:255',
        ]);

        try {
            // Ensure all queries successfully executed
            DB::beginTransaction();

            $billboard = Billboard::findOrFail($request->id);
            $location = Location::find($billboard->location_id);

            $coords = explode(',', $request->gpsCoordinate);
            $gpslatitude = trim($coords[0]);
            $gpslongitude = trim($coords[1]);

            if ($location) {
                $location->update([
                    'name' => $request->location_name, 
                ]);
            }

            // Map prefix to full type name
            $prefixMap = [
                'BB' => 'Billboard',
                'TB' => 'Tempboard',
                'BU' => 'Bunting',
                'BN' => 'Banner',
            ];

            $prefix = $request->type; // sent from JS, e.g., "BB"
            $fullType = $prefixMap[$prefix] ?? 'Unknown'; // map to full name

            $fullType = $prefixMap[$request->type] ?? $request->type; // fallback in case unknown

            $billboard->update([
                'prefix'         => $prefix,    // store the short code
                'type'           => $fullType,  // store the full name
                'size'           => $request->size,
                'lighting'       => $request->lighting,
                'state_id'       => $request->state_id,
                'district_id'    => $request->district_id,
                'gps_latitude'   => $gpslatitude,
                'gps_longitude'  => $gpslongitude,
                'traffic_volume' => (int)$request->traffic_volume,
                'status'         => (int)$request->status,
                'site_type'      => $request->site_type,
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
     * Delete billboard + all associated images
     */
    public function delete(Request $request)
    {   
        $id = $request->id;

        try {
            DB::beginTransaction();

            // Get billboard
            $billboard = Billboard::findOrFail($id);
            $siteNumber = $billboard->site_number;

            // Delete billboard record
            $billboard->delete();

            // Delete ALL associated images (dynamic cleanup)
            $directory = '/home/bluedale2/public_html/bgocoutdoor.bluedale.com.my/images/billboards';

            $files = Storage::files($directory);

            foreach ($files as $file) {
                if (str_starts_with(basename($file), $siteNumber . '_')) {
                    Storage::delete($file);
                }
            }

            DB::commit();

            return response()->json([
                "success" => "Billboard and all related images deleted successfully",
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage()
            ], 422);
        }
    }


    /**
     * View billboard details
     */
    public function redirectNewTab(Request $request)
    {

        $filter = $request->input('filter');
        $id = $request->input('id');
        
        $billboard_detail = Billboard::leftJoin('locations', 'locations.id', 'billboards.location_id')
            ->leftJoin('districts', 'districts.id', '=', 'locations.district_id')
            ->leftJoin('councils', 'councils.id', '=', 'locations.council_id')
            ->leftJoin('states', 'states.id', '=', 'districts.state_id')
            ->leftJoin('billboard_images', 'billboard_images.billboard_id', 'billboards.id')
            ->select(
                'billboards.*',
                'locations.name as location_name',
                'districts.name as district_name',
                'councils.name as council_name',
                'councils.abbreviation as council_abbrv',
                'states.name as state_name',
                'billboard_images.image_path as billboard_image'
            )
            ->where('billboards.id', $request->id)
            ->first();

        $billboard_images = BillboardImage::where('billboard_id', $request->id)->get();

        return view('billboard.detail', compact('billboard_detail', 'billboard_images'));
    }

    public function viewMap(Request $request)
    {

        $filter = $request->input('filter');
        $id = $request->input('id');
        
        $billboard_detail = Billboard::leftJoin('locations', 'locations.id', 'billboards.location_id')
            ->leftJoin('districts', 'districts.id', '=', 'locations.district_id')
            ->leftJoin('states', 'states.id', '=', 'districts.state_id')
            ->leftJoin('billboard_images', 'billboard_images.billboard_id', 'billboards.id')
            ->select(
                'billboards.*',
                'locations.name as location_name',
                'districts.name as district_name',
                'states.name as state_name',
                'billboard_images.image_path as billboard_image'
            )
            ->where('billboards.id', $request->id)
            ->first();

        $billboard_images = BillboardImage::where('billboard_id', $request->id)->get();

        return view('billboard.detail', compact('billboard_detail', 'billboard_images'));
    }

    public function downloadPdf($id)
    {
        // $billboard = Billboard::with(['location.district.state', 'images'])->findOrFail($id);

        // $billboard = Billboard::with([
        //     'location' => function ($query) {
        //         $query->with([
        //             'district' => function ($query) {
        //                 $query->with('state');
        //             }
        //         ]);
        //     },
        //     'images'
        // ])->findOrFail($id);

        $billboard = Billboard::with([
            'location' => function ($query) {
                $query->with([
                    'district' => function ($query) {
                        $query->with('state');
                    }
                ]);
            }
        ])->findOrFail($id);

        // Hardcode images for testing
        $billboard->images = [
            'images/billboards/' . $billboard->site_number . '_1.png',
            'images/billboards/' . $billboard->site_number . '_2.png',
        ];

        $pdf = PDF::loadView('billboard.export', compact('billboard'))
        ->setPaper('A4', 'landscape'); // 👈 Set orientation here

        return $pdf->download('billboard-detail-' . $billboard->site_number . '.pdf');
    }

    public function exportListPdf(Request $request)
    {
        // ↑ Increase PHP memory limit right at the start
        ini_set('memory_limit', '1024M'); // 1GB
        ini_set('max_execution_time', 300); // 5 minutes
        set_time_limit(300);


        $query = Billboard::with(['location.district.state']);

        if ($request->filled('state_id') && $request->state_id !== 'all') {
            $query->whereHas('location.district.state', fn($q) => $q->where('id', $request->state_id));
        }

        if ($request->filled('district_id') && $request->district_id !== 'all') {
            $query->whereHas('location.district', fn($q) => $q->where('id', $request->district_id));
        }

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->filled('site_type') && $request->site_type !== 'all') {
            $query->where('site_type', $request->site_type);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('size') && $request->size !== 'all') {
            $query->where('size', $request->size);
        }

        $billboards = $query->get();

        // ✅ Create image manager (GD driver is default in most servers)
        $manager = new ImageManager(new Driver());

        foreach ($billboards as $billboard) {
            $resizedImages = [];

            $imagePaths = [
                'images/billboards/' . $billboard->site_number . '_1.png',
                'images/billboards/' . $billboard->site_number . '_2.png',
            ];

            foreach ($imagePaths as $fullPath) {
                if (file_exists($fullPath)) {
                    // Resize and compress
                    $resized = $manager->read($fullPath)
                        ->scale(width: 600)   // auto keeps aspect ratio
                        ->toJpeg(70);         // compress quality

                    $resizedImages[] = 'data:image/jpeg;base64,' . base64_encode($resized->toString());
                }
            }

            $billboard->images = $resizedImages;
        }

        // 📂 Filename
        $filename = 'billboards-master';
        $date = now()->format('Y-m-d');

        if ($request->filled('district_id') && $request->district_id !== 'all') {
            $district = District::find($request->district_id);
            if ($district) {
                $filename = 'billboards-' . Str::slug($district->name) . '-' . $date;
            }
        } elseif ($request->filled('state_id') && $request->state_id !== 'all') {
            $state = State::find($request->state_id);
            if ($state) {
                $filename = 'billboards-' . Str::slug($state->name) . '-' . $date;
            }
        } else {
            $filename .= '-' . $date;
        }

        $pdf = PDF::loadView('billboard.exportlist', compact('billboards'))
        ->setPaper('A4', 'landscape'); // 👈 Set orientation here

        return $pdf->download($filename . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $filters = $request->only(['status','state','district','type','site_type','size']);

        // ✅ Base name logic (match title rules in BillboardExport)
        $baseName = "Billboard_List";
        if (!empty($filters['site_type']) && $filters['site_type'] !== "all") {
            $baseName = ucfirst($filters['site_type']) . "_Stock_Inventory_List";
        } elseif (!empty($filters['type']) && $filters['type'] !== "all") {
            $baseName = ucfirst($filters['type']) . "_Stock_Inventory_List";
        }

        // ✅ Final filename
        $fileName = $baseName . "_" . now()->format('dmY') . ".xlsx";

        return Excel::download(new BillboardExport($filters), $fileName);
    }










    public function uploadImage(Request $request) 
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $siteNumber = $request->input('site_number'); 
            $extension = 'png';

            $directory = '/home/bluedale2/public_html/bgocoutdoor.bluedale.com.my/images/billboards';

            // Limit to 2 images
            $existingFiles = glob($directory . '/' . $siteNumber . '_*.png');
            $siteFiles = array_filter($existingFiles, fn($f) => str_starts_with(basename($f), $siteNumber . '_'));

            if (count($siteFiles) >= 2) {
                return response()->json([
                    'message' => 'Maximum of 2 images already uploaded for this site.'
                ], 400);
            }

            // Sequence number
            // Find available slot (1 or 2)
            $usedNumbers = [];
            foreach ($siteFiles as $f) {
                if (preg_match('/_(\d+)\.png$/', $f, $m)) {
                    $usedNumbers[] = (int)$m[1];
                }
            }

            $sequence = null;
            for ($i = 1; $i <= 2; $i++) {
                if (!in_array($i, $usedNumbers)) {
                    $sequence = $i;
                    break;
                }
            }

            if (!$sequence) {
                return response()->json([
                    'message' => 'Maximum of 2 images already uploaded for this site.'
                ], 400);
            }

            $filename = $siteNumber . '_' . $sequence . '.' . $extension;

            $path = $directory . '/' . $filename;

            // Check original file size in bytes
            $fileSize = $file->getSize(); 
            $imageData = null;

            if ($fileSize > 1024 * 1024) { 
                // > 1 MB → compress/resize
                $imageData = (string) Image::read($file)
                    ->scale(width: 400)   // resize if large
                    ->toPng();
            } else {
                // <= 1 MB → keep as-is
                $imageData = file_get_contents($file->getRealPath());
            }

            // Save image
            file_put_contents($path, $imageData);

            // Optimize PNG (optional, can skip if already small)
            try {
                $optimizer = OptimizerChainFactory::create();
                $optimizer->optimize($path);
            } catch (\Throwable $e) {
                \Log::warning("PNG optimization skipped: " . $e->getMessage());
            }

            // Public URL
            $url = asset('images/billboards/' . $filename) . '?v=' . time();

            return response()->json([
                'message'  => 'File uploaded successfully',
                'filename' => $filename,
                'url'      => $url
            ], 200, ['Content-Type' => 'application/json']);
        }

        return response()->json(['message' => 'No file uploaded'], 400);
    }

    public function deleteImage(Request $request)
    {
        $filename = $request->input('filename');
        $directory = '/home/bluedale2/public_html/bgocoutdoor.bluedale.com.my/images/billboards';

        $path = $directory . '/' . $filename;

        if (file_exists($path)) {
            unlink($path);
            return response()->json(['message' => 'File deleted successfully']);
        }

        return response()->json(['message' => 'File not found'], 404);
    }


}