<?php

namespace App\Http\Controllers\Location;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\ClientCompany;
use App\Models\User;
use App\Models\Billboard;
use App\Models\State;
use App\Models\District;
use App\Models\Location;

use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PushNotificationController;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    public function getDistrictsByState(Request $request)
    {
        $stateId = $request->state_id;

        $districts = District::where('state_id', $stateId)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json($districts);
    }

    public function getLocationsByDistrict(Request $request)
    {
        $districtId = $request->district_id;

        $locations = Location::where('district_id', $districtId)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json($locations);
    }

    public function getAllDistricts()
    {
        return response()->json(
            \App\Models\District::orderBy('name', 'ASC')->get()
        );
}
}