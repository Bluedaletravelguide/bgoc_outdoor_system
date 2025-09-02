@extends('layouts.main')

@section('title')
<title>BGOC Outdoor System - Billboard Master</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Billboard Master
    </h2>
</div>

<div class="intro-y box p-5 mt-5">
    <div class="mb-5 p-5 rounded-md" style="background-color:#ECF9FD;">
        <h2 class="text-lg font-medium">
            Billboard Master
        </h2>
        <p class="w-12 flex-none xl:w-auto xl:flex-initial ml-2">
            <i class="font-bold">Billboard Master</i> - Lorem ipsum.
        </p>
    </div>
    
    <!-- BEGIN: Billboard Filter-->
    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
        <form class="xl:flex sm:mr-auto">
            <div class="sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Status</label>
                <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="filterBillboardStatus">
                    <option value="all">All</option>
                    @foreach ($billboardStatus as $status)
                        <option value="{{ $status }}">
                            {{ $status == 1 ? 'Active' : 'Inactive' }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if (Auth::guard('web')->user()->hasRole(['superadmin', 'admin']))
            <div class="sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">State</label>
                <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="filterBillboardState">
                    <option value="all">All</option>
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>
            

            <div class="sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">District</label>
                <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="filterBillboardDistrict">
                    <option value="all">All</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>

            <br>

            <div class="sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Type</label>
                <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="filterBillboardType">
                    <option value="all">All</option>
                    @foreach ($billboardTypes as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Size</label>
                <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="filterBillboardSize">
                    <option value="all">All</option>
                    @foreach ($billboardSize as $size)
                        <option value="{{ $size }}">{{ $size }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <!-- <div class="mt-2 xl:mt-0">
                <button type="button" class="button w-full sm:w-16 bg-theme-32 text-white" id="filterBillboardButton">Filter</button>
            </div> -->
        </form>

        <div class="text-center"> 
            <a href="javascript:;" data-toggle="modal" data-target="#addBillboardModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add New Stock
            </a>
            <a href="#" id="exportBtn" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-9 text-white" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor"
                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-download w-4 h-4 mr-2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Download Details
            </a>
            <a href="{{ route('stockInventory.index')}}" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white">
                <svg xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor"
                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-download w-4 h-4 mr-2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Inventory
            </a>
        </div> 
    </div>
    <!-- END: Billboard Filter -->

    <!-- BEGIN: Billboard List -->
    <div class="overflow-x-auto scrollbar-hidden">
        <table class="table table-report mt-5" id="billboard_table">
            <thead>
                <tr class="bg-theme-1 text-white">
                    <th>No</th>
                    <th>Site #</th>
                    <th>Type</th>
                    <th>Size</th>
                    <th>Lighting</th>
                    <th>Area</th>
                    <th>Region</th>
                    <th>Date Created</th>
                    <th>Status</th>
                    <th class="dt-exclude-export dt-no-sort">Show Detail</th>
                    <th class="dt-exclude-export dt-no-sort">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- END: Billboard List -->
</div>
@endsection('app_content')

@section('modal_content')
<!-- Create Billboard Modal -->
    <div class="row flex flex-col sm:flex-row sm:items-end xl:items-start mb-2">
        <div class="modal" id="addBillboardModal">
            <div class="modal__content">
                <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">Add New Stock</h2>
                </div>
                <form>
                    <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label>Outdoor Type</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputBillboardType">
                                <option value="">-- Select Outdoor Type --</option>
                                <option value="BB">Billboard</option>
                                <option value="TB">Tempboard</option>
                                <option value="BU">Bunting</option>
                                <option value="BN">Banner</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Size (H)'x(W)'</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputBillboardSize">
                                <option value="">-- Select Size --</option>
                                <option value="15x10">15x10</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Lighting</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputBillboardLighting">
                                <option value="">-- Select Lighting --</option>
                                <option value="None">None</option>
                                <option value="TNB">TNB</option>
                                <option value="SOLAR">SOLAR</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>State</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputBillboardState">
                                <option value="">-- Select State --</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>District</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputBillboardDistrict">
                                <option value="">-- Select District --</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Council</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputBillboardCouncil">
                                <option value="">-- Select Council --</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Area</label>
                            <input type="text" class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputBillboardLocation" placeholder="Enter area name">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>State/Private Land</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputBillboardLand">
                                <option value="">-- Select option --</option>
                                <option value="A">A - State Land</option>
                                <option value="B">B - Private Land</option>
                                <option value="C">C - KKR</option>
                                <option value="D">D - Others</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="inputGPSCoordinate" class="form-label">GPS Coordinate</label>
                            <input 
                                type="text" 
                                class="input w-full border mt-2 flex-1" 
                                id="inputGPSCoordinate" 
                                name="gps_coordinate"
                                pattern="^-?([0-8]?\d(\.\d+)?|90(\.0+)?),\s*-?(1[0-7]\d(\.\d+)?|180(\.0+)?)$"
                                placeholder="e.g. 3.1390, 101.6869" 
                                required
                            >
                            <small class="text-gray-500">Format: latitude (-90 → 90), longitude (-180 → 180)</small>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="inputBillboardTrafficVolume" class="form-label">Traffic Volume</label>
                            <input 
                                type="number" 
                                class="input w-full border mt-2 flex-1" 
                                id="inputBillboardTrafficVolume" 
                                name="traffic_volume"
                                min="0" 
                                step="1" 
                                placeholder="e.g. 50000" 
                                required
                            >
                        </div>
                    </div>

                    <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                        <button type="submit" class="button w-20 bg-theme-1 text-white" id="billboardAddButton">Submit</button>
                    </div>
                </form>
            </div>
        </div> 
    </div>
<!-- Create Modal End -->

<!-- Edit Billboard Modal -->
    <div class="row flex flex-col sm:flex-row sm:items-end xl:items-start mb-2">
        <div class="modal" id="billboardEditModal">
            <div class="modal__content">
                <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">Edit Stock</h2>
                </div>
                <form>
                    <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <input type="hidden" id="editBillboardModalId" name="id">
                            <label>Outdoor Type</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardType" disabled>
                                <option value="">-- Select Outdoor Type --</option>
                                <option value="BB">Billboard</option>
                                <option value="TB">Tempboard</option>
                                <option value="BU">Bunting</option>
                                <option value="BN">Banner</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Billboard Size</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardSize">
                                <option value="">-- Select Size --</option>
                                <option value="15x10">15x10</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Lighting</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardLighting">
                                <option value="">-- Select Lighting --</option>
                                <option value="None">None</option>
                                <option value="TNB">TNB</option>
                                <option value="SOLAR">SOLAR</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>State</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardState"  disabled>
                                <option value="">-- Select State --</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>District</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardDistrict" disabled>
                                <option value="">-- Select District --</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Council</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardCouncil" disabled>
                                <option value="">-- Select Council --</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Area</label>
                            <input type="text" class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardLocation" placeholder="Enter area name">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="editGPSCoordinate" class="form-label">GPS Coordinate</label>
                            <input 
                                type="text" 
                                class="input w-full border mt-2 flex-1" 
                                id="editGPSCoordinate" 
                                name="gps_coordinate"
                                placeholder="e.g. 3.1390, 101.6869" 
                                required
                            >
                            <small class="text-gray-500">Format: latitude, longitude</small>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Traffic Volume</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="editBillboardTrafficVolume" value="" required>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Status</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardStatus">
                                <option value="">-- Select option --</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                        <button type="submit" class="button w-20 bg-theme-1 text-white" id="billboardEditButton">Submit</button>
                    </div>
                </form>
            </div>
        </div> 
    </div>
<!-- Edit Modal End -->

<!-- BEGIN: Billboard Delete Modal -->
<div class="modal" id="billboardDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm delete this billboard info? This process cannot be undone.</div>
        </div>

        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="billboardDeleteButton" onclick="billboardDeleteButton()">Delete</button>
        </div>
    </div>
</div>
<!-- END: Service Request Reject Modal -->

@endsection('modal_content')

@section('script')

<!-- searchable dropdown -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $('#filterBillboardState').on('change', function () {
        let stateId = $(this).val();

        $('#filterBillboardDistrict').empty().append('<option value="all">All</option>');

        if (stateId === 'all') {
            $.ajax({
                url: '{{ route("location.getAllDistricts") }}',
                type: 'GET',
                success: function (districts) {
                    districts.forEach(function (district) {
                        $('#filterBillboardDistrict').append(`<option value="${district.id}">${district.name}</option>`);
                    });
                },
                error: function () {
                    alert('Failed to load all districts.');
                }
            });
        } else {
            $.ajax({
                url: '{{ route("location.getDistricts") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    state_id: stateId
                },
                success: function (districts) {
                    districts.forEach(function (district) {
                        $('#filterBillboardDistrict').append(`<option value="${district.id}">${district.name}</option>`);
                    });
                },
                error: function () {
                    alert('Failed to load districts.');
                }
            });
        }
    });

    document.getElementById('exportBtn').addEventListener('click', function (e) {
        e.preventDefault();

        // Read values from your filter fields
        let state = document.getElementById('filterBillboardState')?.value || 'all';
        let district = document.getElementById('filterBillboardDistrict')?.value || 'all';
        let type = document.getElementById('filterBillboardType')?.value || 'all';
        let size = document.getElementById('filterBillboardSize')?.value || 'all';
        let status = document.getElementById('filterBillboardStatus')?.value || 'all';

        // Build query string
        let query = new URLSearchParams({
            state_id: state,
            district_id: district,
            type: type,
            size: size,
            status: status
        }).toString();

        // Redirect with query string
        let exportUrl = '{{ route("billboards.export.pdf") }}' + '?' + query;
        window.open(exportUrl, '_blank');
    });


    // Function to reload the DataTable when any filter changes
    function setupAutoFilter() {
        const tableElement = $('#billboard_table');
        if (!$.fn.DataTable.isDataTable(tableElement)) {
            console.warn("DataTable is not yet initialized.");
            return;
        }

        const table = tableElement.DataTable();

        $('#filterBillboardStatus, #filterBillboardState, #filterBillboardDistrict, #filterBillboardType, #filterBillboardSize').on('change', function () {
            table.ajax.reload();
        });
    }

    // Add site to In Inventory
    function siteInAdd() {
        let html = `
            <br><div class="siteIn">
                <div class="mb-3">
                    <label class="block">Site</label>
                    <select class="input w-full border mt-2 select2" name="sites_in[]">
                        <option selected value="">Select an option</option>
                        @foreach ($billboards as $billboard)
                            <option 
                                value="{{ $billboard->id }}" 
                                data-type="{{ $billboard->type }}" 
                                data-size="{{ $billboard->size }}">
                                {{ $billboard->site_number }} - {{ $billboard->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block">Type</label>
                    <input type="text" class="input w-full border mt-1" name="types_in[]" readonly>
                </div>
                <div class="mb-3">
                    <label class="block">Size</label>
                    <input type="text" class="input w-full border mt-1" name="sizes_in[]" readonly>
                </div>
                <div class="mb-3">
                    <label class="block"><strong>Quantity In</strong></label>
                    <input type="number" class="input w-full border mt-1" name="qtys_in[]">
                </div>
                <div class="mb-3">
                    <a href="javascript:void(0);" class="button bg-theme-6 text-white" onclick="removeSiteIn(this)">
                        Remove
                    </a>
                </div>
            </div>`;

        // Append
        $("#siteInContainer").append(html);

        // Re-init select2 for all .select2 (new + old)
        $("#siteInContainer .select2").select2({
            width: '100%'
        });

        updateTotalIn();
    }

    function removeSiteIn(el) {
        el.closest(".siteIn").remove();
        updateTotalIn();
    }

    // Add site to Out Inventory
    function siteOutAdd() {
        let html = `
            <br><div class="siteOut">
                <div class="mb-3">
                    <label class="block">Site</label>
                    <select class="input w-full border mt-2 select2" name="sites_out[]" required>
                        <option selected value="">Select an option</option>
                        @foreach ($billboards as $billboard)
                            <option 
                                value="{{ $billboard->id }}" 
                                data-type="{{ $billboard->type }}" 
                                data-size="{{ $billboard->size }}">
                                {{ $billboard->site_number }} - {{ $billboard->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block">Type</label>
                    <input type="text" class="input w-full border mt-1" name="types_out[]" readonly>
                </div>
                <div class="mb-3">
                    <label class="block">Size</label>
                    <input type="text" class="input w-full border mt-1" name="sizes_out[]" readonly>
                </div>
                <div class="mb-3">
                    <label class="block"><strong>Quantity Out</strong></label>
                    <input type="number" class="input w-full border mt-1" name="qtys_out[]" required>
                </div>
                <div class="mb-3">
                    <a href="javascript:void(0);" class="button bg-theme-6 text-white" onclick="removeSiteOut(this)">
                        Remove
                    </a>
                </div>
            </div>`;
        
        $("#siteOutContainer").append(html);

        // Re-init select2
        $("#siteOutContainer .select2").select2({
            width: '100%'
        });

        updateTotalOut();
    }

    function removeSiteOut(el) {
        el.closest(".siteOut").remove();
        updateTotalOut();
    }

    // Add In Site (Edit)
    function siteInEditAdd() {
        let html = `
            <div class="siteInEdit">
                <div class="mb-3">
                    <label class="block">Site</label>
                    <select class="input w-full border mt-2 select2" name="sites_in_edit[]">
                        <option selected value="">Select an option</option>
                        @foreach ($billboards as $billboard)
                            <option 
                                value="{{ $billboard->id }}" 
                                data-type="{{ $billboard->type }}" 
                                data-size="{{ $billboard->size }}">
                                {{ $billboard->site_number }} - {{ $billboard->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block">Type</label>
                    <input type="text" class="input w-full border mt-1" name="types_in_edit[]" readonly>
                </div>
                <div class="mb-3">
                    <label class="block">Size</label>
                    <input type="text" class="input w-full border mt-1" name="sizes_in_edit[]" readonly>
                </div>
                <div class="mb-3">
                    <label class="block"><strong>Quantity In</strong></label>
                    <input type="number" class="input w-full border mt-1" name="qtys_in_edit[]">
                </div>
                <div class="mb-3">
                    <a href="javascript:void(0);" class="button bg-theme-6 text-white" onclick="removeSiteInEdit(this)">
                        Remove
                    </a>
                </div>
            </div>`;
        
        $("#siteInEditContainer").append(html);

        // Re-init select2
        $("#siteInEditContainer .select2").select2({
            width: '100%'
        });
    }

    function removeSiteInEdit(el) {
        el.closest(".siteInEdit").remove();
    }

    // Add Out Site (Edit)
    function siteOutEditAdd() {
        let html = `
            <div class="siteOutEdit">
                <div class="mb-3">
                    <label class="block">Site</label>
                    <select class="input w-full border mt-2 select2" name="sites_out_edit[]">
                        <option selected value="">Select an option</option>
                        @foreach ($billboards as $billboard)
                            <option 
                                value="{{ $billboard->id }}" 
                                data-type="{{ $billboard->type }}" 
                                data-size="{{ $billboard->size }}">
                                {{ $billboard->site_number }} - {{ $billboard->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block">Type</label>
                    <input type="text" class="input w-full border mt-1" name="types_out_edit[]" readonly>
                </div>
                <div class="mb-3">
                    <label class="block">Size</label>
                    <input type="text" class="input w-full border mt-1" name="sizes_out_edit[]" readonly>
                </div>
                <div class="mb-3">
                    <label class="block"><strong>Quantity Out</strong></label>
                    <input type="number" class="input w-full border mt-1" name="qtys_out_edit[]">
                </div>
                <div class="mb-3">
                    <a href="javascript:void(0);" class="button bg-theme-6 text-white" onclick="removeSiteOutEdit(this)">
                        Remove
                    </a>
                </div>
            </div>`;

        $("#siteOutEditContainer").append(html);

        // Re-init select2
        $("#siteOutEditContainer .select2").select2({
            width: '100%'
        });
    }

    function removeSiteOutEdit(el) {
        el.closest(".siteOutEdit").remove();
    }

    // Handle auto-fill Type & Size for ADD modal
    $(document).on('change', '#siteInContainer .select2, #siteOutContainer .select2', function() {
        let selected = $(this).find(':selected');
        let type = selected.data('type') || '';
        let size = selected.data('size') || '';

        // find the nearest .siteIn or .siteOut row
        let row = $(this).closest('.siteIn, .siteOut');
        row.find('input[name="types_in[]"], input[name="types_out[]"]').val(type);
        row.find('input[name="sizes_in[]"], input[name="sizes_out[]"]').val(size);
    });

    // Handle auto-fill Type & Size for EDIT modal
    $(document).on('change', '#siteInEditContainer .select2, #siteOutEditContainer .select2', function() {
        let selected = $(this).find(':selected');
        let type = selected.data('type') || '';
        let size = selected.data('size') || '';

        let row = $(this).closest('.siteInEdit, .siteOutEdit');
        row.find('input[name="types_in_edit[]"], input[name="types_out_edit[]"]').val(type);
        row.find('input[name="sizes_in_edit[]"], input[name="sizes_out_edit[]"]').val(size);
    });

    // Function to calculate total In
    function updateTotalIn() {
        let total = 0;
        document.querySelectorAll("input[name='qtys_in[]']").forEach(function(input) {
            let val = parseInt(input.value) || 0;
            total += val;
        });
        document.getElementById("balContractor").value = total;
    }

    // Function to calculate total Out
    function updateTotalOut() {
        let total = 0;
        document.querySelectorAll("input[name='qtys_out[]']").forEach(function(input) {
            let val = parseInt(input.value) || 0;
            total += val;
        });
        document.getElementById("balBgoc").value = total;
    }

    // Attach events when typing in Quantity fields
    $(document).on("input", "input[name='qtys_in[]']", function() {
        updateTotalIn();
    });

    $(document).on("input", "input[name='qtys_out[]']", function() {
        updateTotalOut();
    });

    
    
    $(document).ready(function() {
        // Global variables
        var filterBillboardStatus;

        document.getElementById("billboardDeleteButton").addEventListener("click", billboardDeleteButton);

        // Initialize Select2 with search
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true,
            width: '100%'
        });

        // When "State" is changed in add form
        $('#inputBillboardState').on('change', function () {
            let stateId = $(this).val();

            // Reset District & Council dropdowns
            $('#inputBillboardDistrict').empty().append('<option value="">-- Select District --</option>');
            $('#inputBillboardCouncil').empty().append('<option value="">-- Select Council --</option>');

            if (stateId !== '') {
                $.ajax({
                    url: '{{ route("location.getDistricts") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        state_id: stateId
                    },
                    success: function (districts) {
                        districts.forEach(function (district) {
                            $('#inputBillboardDistrict').append(`<option value="${district.id}">${district.name}</option>`);
                        });
                    },
                    error: function () {
                        alert('Failed to load districts.');
                    }
                });
            }
        });

        // When "District" is changed in add form
        $('#inputBillboardDistrict').on('change', function () {
            let stateId = $('#inputBillboardState').val();   // ✅ get the selected state
            let districtId = $(this).val();

            // Reset Council dropdown
            $('#inputBillboardCouncil').empty().append('<option value="">-- Select Council --</option>');

            if (stateId !== '') {
                $.ajax({
                    url: '{{ route("location.getCouncils") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        state_id: stateId   // ✅ Correct
                    },
                    success: function (councils) {
                        councils.forEach(function (council) {
                            $('#inputBillboardCouncil').append(
                                `<option value="${council.id}">${council.abbreviation} - ${council.name}</option>`
                            );
                        });
                    },
                    error: function () {
                        alert('Failed to load councils.');
                    }
                });
            }
        });




        document.getElementById("billboardAddButton").addEventListener("click", function (e) {
            e.preventDefault();
            billboardAddButton();
        });

        





        //Store the ID of the last clicked update status modal when it's triggered
        (function() {
            $(document).on('click', "[data-target='#workOrderStatusUpdateModal'], [data-target='#workOrderAssignTcModal']", function() {
                originalWorkOrderIdStatusUpdate = ($(this).attr('id')).split("-")[2];
                // console.log(originalWorkOrderIdStatusUpdate);
            });

            document.getElementById('billboardDeleteButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();
            });
        })();

        // Store the ID of the last clicked modal when it's triggered
        (function() {
            $(document).on('click', "[data-toggle='modal']", function() {
                lastClickedLink = $(this).attr('id');
                // Grab row client id
                originalWorkOrderId = $(event.target).closest('tr').find('td:nth-child(9) a').attr('id').split("-")[1];
                console.log(originalWorkOrderId) ;         
            });
        })();

        // Open modal
        function openAltEditorModal(element) {
            cash(element).modal('show');
        }
        // Close modal
        function closeAltEditorModal(element) {
            cash(element).modal('hide');
        }

        // Setup the on-going Billboard datatable
        function initBillboardDatatable() {
            const dt            = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName     = `Billboard_List_${formattedDate}_${formattedTime}`;

            const table = $('#billboard_table').DataTable({
                destroy: true,
                debug: true,
                processing: true,
                searching: true,
                serverSide: true,
                ordering: true,
                order: [
                    [7, 'desc']
                ],
                pagingType: 'full_numbers',
                pageLength: 25,
                aLengthMenu: [
                    [25, 50, 75, -1],
                    [25, 50, 75, "All"]
                ],
                iDisplayLength: 25,
                ajax: {
                    url: "{{ route('billboard.list') }}",
                    dataType: "json",
                    type: "POST",
                    method:"POST",
                    data: function(d) {
                        d._token    = $('meta[name="csrf-token"]').attr('content');
                        d.status    = $('#filterBillboardStatus').val();
                        d.state     = $('#filterBillboardState').val();
                        d.district  = $('#filterBillboardDistrict').val();
                        d.type      = $('#filterBillboardType').val();
                        d.size      = $('#filterBillboardSize').val();
                    },
                    dataSrc: function(json) {
                        console.log(json);
                        json.recordsTotal       = json.recordsTotal;
                        json.recordsFiltered    = json.recordsFiltered;
                        return json.data;
                    }
                },
                dom: "lBfrtip",
                buttons: [{
                        extend: "csv",
                        className: "button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-7 text-white",
                        title: $fileName,
                        exportOptions: {
                            columns: ":not(.dt-exclude-export)"
                        },
                        init: function(api, node, config) {
                            $(node).removeClass('dt-button');
                            $(node).removeClass('buttons-html5');
                        },
                    },
                    {
                        extend: "excel",
                        className: "button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-7 text-white",
                        title: $fileName,
                        exportOptions: {
                            columns: ":not(.dt-exclude-export)"
                        },
                        init: function(api, node, config) {
                            $(node).removeClass('dt-button');
                            $(node).removeClass('buttons-html5');
                        },
                    },
                    {
                        extend: "print",
                        className: "button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-7 text-white",
                        title: $fileName,
                        // including printing image
                        exportOptions: {
                            columns: ":not(.dt-exclude-export)",
                            stripHtml: false,
                        },
                        init: function(api, node, config) {
                            $(node).removeClass('dt-button');
                            $(node).removeClass('buttons-html5');
                        },
                    },
                ],
                columnDefs: [{
                    targets: 'dt-no-sort',
                    orderable: false
                }],
                columns: [
                    {
                        data: null, // <-- important
                        name: 'no',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "site_number",
                    },
                    {
                        data: "type",
                    },
                    {
                        data: "size",
                    },
                    {
                        data: "lighting",
                    },
                    {
                        data: "location_name",
                    },
                    {
                        data: "region",
                    },
                    {
                        data: "created_at",
                    },
                    {
                        data: "status",
                        type: "readonly",
                        render: function(data, type, row) {
                            let element = ``
                            if (data == 1){
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-9 text-white">ACTIVE</a>`;
                            } else if (data == 0){
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-6 text-white">INACTIVE</a>`;
                            }
                            
                            return element;
                        }
                    },
                    {
                        data: "id",
                        render: function(data, type, row) {
                            var a = "{{ route('billboard.detail', ['id'=>':data'] )}}".replace(':data', data);
                            let mapUrl = `https://www.google.com/maps?q=${row.gps_latitude},${row.gps_longitude}`;
                            let element = 
                                `<div class="flex flex-row">
                                    <a href="javascript:;" id="detail-` + data + `"
                                        class="button w-24 inline-block mr-2 mb-2 bg-theme-9 text-white" data-toggle="button" onclick="window.open('${a}')" >
                                        Site location
                                    </a>

                                    <!-- Map Button -->
                                    <a href="${mapUrl}" target="_blank"
                                    class="button w-24 inline-block mr-2 mb-2 bg-theme-1 text-white">
                                    Map
                                    </a>
                                </div>`;

                            return element;
                        }
                    },
                    {
                        data: "id",
                        render: function(data, type, row) {
                            let element = `
                            <div class="flex items-center space-x-2">
                                <!-- Edit Button -->
                                <a href="javascript:;" 
                                    class="button w-24 inline-block mr-2 mb-2 bg-theme-1 text-white edit-billboard" 
                                    data-id="${row.id}"
                                    data-type="${row.type_prefix}"
                                    data-size="${row.size}"
                                    data-lighting="${row.lighting}"
                                    data-state_id="${row.state_id}"
                                    data-district_id="${row.district_id}"
                                    data-council_id="${row.council_id}"
                                    data-location="${row.location_name}"
                                    data-gps_latitude="${row.gps_latitude}"
                                    data-gps_longitude="${row.gps_longitude}"
                                    data-traffic_volume="${row.traffic_volume}"
                                    data-status="${row.status}"
                                >
                                    Edit
                                </a>

                                <!-- Delete Button -->
                                <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#billboardDeleteModal" id="delete-billboard-` + data + `">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 w-4 h-4 mr-1">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg> 
                                </a>
                            </div>`;

                            return element;
                        }
                    },
                ],
                createdRow: function(row, data) {
                    $(row)
                        .attr('data-prefix', data.prefix)
                        .attr('data-size', data.size)
                        .attr('data-lighting', data.lighting)
                        .attr('data-state_id', data.state_id)
                        .attr('data-district_id', data.district_id)
                        .attr('data-location_id', data.location_id);
                }
            });

            // Add classes to the "dt-buttons" div
            var dtButtonsDiv = document.querySelector(".dt-buttons");
            if (dtButtonsDiv) {
                dtButtonsDiv.classList.add("mt-2");
            }

            // Update styling for the filter input
            var filterDiv = document.getElementById("billboard_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv     = document.getElementById("billboard_table_info");
            var paginateDiv = document.getElementById("Billboard_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "billboard_table_length" div and its select element
            var existingDiv = document.getElementById("billboard_table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }

            @if (Auth::guard('web')->user()->can('work_order.edit'))
            // Open modal to edit Billboard
            workOrderEditModal();
            @endif

            // billboardEditModal();
        };

        initBillboardDatatable();
        setupAutoFilter();
        billboardEditModal();

        $('#billboard_table').off('click', '.edit-billboard').on('click', '.edit-billboard', function () {
            const $this = $(this);
            const billboardID = $this.data('id');

            // Set values
            $('#editBillboardType').val($this.data('type'));
            $('#editBillboardSize').val($this.data('size'));
            $('#editBillboardLighting').val($this.data('lighting'));
            
            // Combine latitude & longitude into one coordinate
            const latitude = $this.data('gps_latitude');
            const longitude = $this.data('gps_longitude');
            $('#editGPSCoordinate').val(latitude + ', ' + longitude);
            
            $('#editBillboardTrafficVolume').val($this.data('traffic_volume'));
            $('#editBillboardStatus').val($this.data('status'));
            $('#editBillboardModalId').val(billboardID);

            // Get IDs
            const stateID    = $this.data('state_id');
            const districtID = $this.data('district_id');
            const councilID  = $this.data('council_id');
            const location   = $this.data('location');

            // ✅ Set state
            $('#editBillboardState').val(stateID).trigger('change');

            // ✅ Fetch districts
            $.post('{{ route("location.getDistricts") }}', {
                _token: '{{ csrf_token() }}',
                state_id: stateID
            }, function (districts) {
                $('#editBillboardDistrict').empty().append(`<option value="">-- Select District --</option>`);
                districts.forEach(function (d) {
                    $('#editBillboardDistrict').append(`<option value="${d.id}">${d.name}</option>`);
                });
                $('#editBillboardDistrict').val(districtID).trigger('change');

                // ✅ Fetch councils after districts load
                $.post('{{ route("location.getCouncils") }}', {
                    _token: '{{ csrf_token() }}',
                    state_id: stateID
                }, function (councils) {
                    $('#editBillboardCouncil').empty().append(`<option value="">-- Select Council --</option>`);
                    councils.forEach(function (c) {
                        $('#editBillboardCouncil').append(`<option value="${c.id}">${c.name} (${c.abbreviation})</option>`);
                    });
                    $('#editBillboardCouncil').val(councilID).trigger('change');
                });
            });

            // ✅ Location
            $('#editBillboardLocation').val(location);

            // Open modal
            openAltEditorModal("#billboardEditModal");
        });

        // 🔄 On State change => fetch districts + councils
        $('#editBillboardState').on('change', function () {
            let stateID = $(this).val();

            $('#editBillboardDistrict').html('<option value="">-- Loading Districts --</option>');
            $('#editBillboardCouncil').html('<option value="">-- Loading Councils --</option>');
            $('#editBillboardLocation').html('<option value="">-- Select Location --</option>');

            if (stateID) {
                // districts
                $.get('/get-districts/' + stateID, function (data) {
                    let options = '<option value="">-- Select District --</option>';
                    data.forEach(function (district) {
                        options += `<option value="${district.id}">${district.name}</option>`;
                    });
                    $('#editBillboardDistrict').html(options);
                });

                // councils
                $.get('/get-councils/' + stateID, function (data) {
                    let options = '<option value="">-- Select Council --</option>';
                    data.forEach(function (c) {
                        options += `<option value="${c.id}">${c.abbreviation} - ${c.name} </option>`;
                    });
                    $('#editBillboardCouncil').html(options);
                });
            }
        });

        // 🔄 On District change => fetch locations
        $('#editBillboardDistrict').on('change', function () {
            let districtID = $(this).val();
            $('#editBillboardLocation').html('<option value="">-- Loading Locations --</option>');

            if (districtID) {
                $.get('/get-locations/' + districtID, function (data) {
                    let options = '<option value="">-- Select Location --</option>';
                    data.forEach(function (location) {
                        options += `<option value="${location.id}">${location.name}</option>`;
                    });
                    $('#editBillboardLocation').html(options);
                });
            }
        });




        // Add New Billboard
        function billboardAddButton() {

            // document.getElementById("billboardAddButton").disabled = true;
            // document.getElementById('billboardAddButton').style.display = 'none';

            $.ajax({
                type: 'POST',
                url: "{{ route('billboard.create') }}",
                data: {
                    _token          : $('meta[name="csrf-token"]').attr('content'),
                    type            : document.getElementById("inputBillboardType").value,
                    size            : document.getElementById("inputBillboardSize").value,
                    lighting        : document.getElementById("inputBillboardLighting").value,
                    state           : document.getElementById("inputBillboardState").value,
                    district        : document.getElementById("inputBillboardDistrict").value,
                    council         : document.getElementById("inputBillboardCouncil").value,
                    land            : document.getElementById("inputBillboardLand").value,
                    location        : document.getElementById("inputBillboardLocation").value,
                    gpsCoordinate   : document.getElementById("inputGPSCoordinate").value,
                    trafficvolume   : document.getElementById("inputBillboardTrafficVolume").value,
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#addBillboardModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("inputBillboardType").value = "";
                    document.getElementById("inputBillboardSize").value = "";
                    document.getElementById("inputBillboardLighting").value = "";
                    document.getElementById("inputBillboardState").value = "";
                    document.getElementById("inputBillboardDistrict").value = "";
                    document.getElementById("inputBillboardCouncil").value = "";
                    document.getElementById("inputBillboardLand").value = "";
                    document.getElementById("inputBillboardLocation").value = "";
                    document.getElementById("inputGPSCoordinate").value = "";
                    document.getElementById("inputBillboardTrafficVolume").value = "";

                    // Reload table
                    $('#billboard_table').DataTable().ajax.reload();
                    
                    // Reset the button visibility and enable it for next submission
                    // document.getElementById("billboardAddButton").disabled = false;
                    // document.getElementById('billboardAddButton').style.display = 'inline-block';  // Shows the button again
                },
                error: function(xhr, status, error) {
                    // Display the validation error message
                    var response = JSON.parse(xhr.responseText);
                    var error = "Error: " + response.error;

                    // Show fail toast
                    window.showSubmitToast(error, "#D32929");
                }
            });
        };

        $('#billboardEditButton').on('click', function (e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route("billboard.update") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: $('#editBillboardModalId').val(),
                    type: $('#editBillboardType').val(),
                    size: $('#editBillboardSize').val(),
                    lighting: $('#editBillboardLighting').val(),
                    state_id: $('#editBillboardState').val(),
                    district_id: $('#editBillboardDistrict').val(),
                    council_id: $('#editBillboardCouncil').val(),
                    location_name: $('#editBillboardLocation').val(), // 👈 send as name
                    gpsCoordinate: $('#editGPSCoordinate').val(),
                    traffic_volume: $('#editBillboardTrafficVolume').val(),
                    status: $('#editBillboardStatus').val(),
                    
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#billboardEditModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("editBillboardModalId").value = "";
                    document.getElementById("editBillboardType").value = "";
                    document.getElementById("editBillboardSize").value = "";
                    document.getElementById("editBillboardLighting").value = "";
                    document.getElementById("editBillboardState").value = "";
                    document.getElementById("editBillboardDistrict").value = "";
                    document.getElementById("editBillboardCouncil").value = "";
                    document.getElementById("editBillboardLocation").value = "";
                    document.getElementById("editGPSLongitude").value = "";
                    document.getElementById("editGPSLatitude").value = "";
                    document.getElementById("editGPSCoordinate").value = "";
                    document.getElementById("editBillboardTrafficVolume").value = "";
                    document.getElementById("editBillboardStatus").value = "";

                    // Reload table
                    $('#billboard_table').DataTable().ajax.reload();
                    
                    // Reset the button visibility and enable it for next submission
                    document.getElementById("billboardEditButton").disabled = false;
                    document.getElementById('billboardEditButton').style.display = 'inline-block';  // Shows the button again
                },
                error: function(xhr, status, error) {
                    // Display the validation error message
                    var response = JSON.parse(xhr.responseText);
                    var error = "Error: " + response.error;

                    // Show fail toast
                    window.showSubmitToast(error, "#D32929");
                }
            });
        });


        function billboardEditModal() {
            $(document).off('click', "[id^='edit-']");

            $(document).on('click', "[id^='edit-']", function (event) {
                event.preventDefault();

                let billboardID = $(this).attr('id').split('-')[1];
                let row = $(this).closest('tr');

                let prefix     = row.attr('data-prefix') || "";
                let size       = row.attr('data-size') || "";
                let lighting   = row.attr('data-lighting') || "";
                let stateID    = row.attr('data-state_id') || "";
                let districtID = row.attr('data-district_id') || "";
                let locationID = row.attr('data-location_id') || "";
                let latitude   = row.attr('data-latitude') || "";
                let longitude  = row.attr('data-longitude') || "";
                let traffic    = row.attr('data-traffic') || "";

                $('#editBillboardType').val(prefix);
                $('#editBillboardSize').val(size);
                $('#editBillboardLighting').val(lighting);
                $('#editGPSLatitude').val(latitude);
                $('#editGPSLongitude').val(longitude);
                $('#editGPSCoordinate').val(longitude);
                // Combined GPS coordinate field
                if (latitude && longitude) {
                    $('#editGPSCoordinate').val(latitude + ', ' + longitude);
                } else {
                    $('#editGPSCoordinate').val("");
                }
                $('#editBillboardTrafficVolume').val(traffic);
                $('#editBillboardStatus').val(status);

                // Trigger state change to load districts
                $('#editBillboardState').val(stateID).trigger('change');

                setTimeout(() => {
                    $('#editBillboardDistrict').val(districtID).trigger('change');
                    setTimeout(() => {
                        $('#editBillboardLocation').val(locationID);
                    }, 300);
                }, 300);

                openAltEditorModal("#billboardEditModal");
            });
        }





        // Delete billboard ID
        function billboardDeleteButton() {
            var id = lastClickedLink.split("-")[2];

            $.ajax({
                type: 'POST',
                url: "{{ route('billboard.delete') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id,
                },
                success: function (response) {
                    // Close modal after successfully deleted
                    var element = "#billboardDeleteModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully deleted.", "#91C714");

                    // Reload table
                    $('#billboard_table').DataTable().ajax.reload();

                    // Reload the entire page
                    // location.reload();
                },
                error: function (xhr, status, error) {
                    // Display the validation error message
                    var response = JSON.parse(xhr.responseText);
                    var error = "Error: " + response.error;

                    // Show fail toast
                    window.showSubmitToast(error, "#D32929");
                }
            });
        }
































        // Store the ID of the last clicked modal when it's triggered
        (function() {
            $(document).on('click', "[data-toggle='modal']", function() {
                lastClickedLink = $(this).attr('id');
            });
        })();
    });
</script>
@endsection('script')
