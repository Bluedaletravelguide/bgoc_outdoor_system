@extends('layouts.main')

@section('title')
<title>BGOC Outdoor System - Billboard Info</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Billboard
    </h2>
</div>

<div class="intro-y box p-5 mt-5">
    <div class="mb-5 p-5 rounded-md" style="background-color:#ECF9FD;">
        <h2 class="text-lg font-medium">
            Billboard
        </h2>
        <p class="w-12 flex-none xl:w-auto xl:flex-initial ml-2">
            <i class="font-bold">Billboard</i> - Lorem ipsum.
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
                Add New Billboard
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
                    <th>Site Number</th>
                    <th>Type</th>
                    <th>Size</th>
                    <th>Lighting</th>
                    <th>Area</th>
                    <th>Region</th>
                    <th>Date Registered</th>
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
                    <h2 class="font-medium text-base mr-auto">Add New Billboard</h2>
                </div>
                <form>
                    <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label>Billboard Type</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputBillboardType">
                                <option value="">-- Select Bilboard Type --</option>
                                @foreach ($billboardTypes as $prefix => $type)
                                    <option value="{{ $prefix }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Billboard Size</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputBillboardSize">
                                <option value="">-- Select Size --</option>
                                @foreach ($billboardSize as $size)
                                    <option value="{{ $size }}">{{ $size }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Lighting</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputBillboardLighting">
                                <option value="">-- Select Lighting --</option>
                                @foreach ($billboardLighting as $lighting)
                                    <option value="{{ $lighting }}">{{ $lighting }}</option>
                                @endforeach
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
                            <label>Area</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputBillboardLocation">
                                <option value="">-- Select Area --</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="start_date" class="form-label">GPS Longitude</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="inputGPSLongitude" value="" required>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label for="end_date" class="form-label">GPS Latitude</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="inputGPSLatitude" value="" required>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Traffic Volume</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="inputBillboardTrafficVolume" value="" required>
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
                    <h2 class="font-medium text-base mr-auto">Edit Billboard</h2>
                </div>
                <form>
                    <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label>Billboard Type</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardType">
                                <option value="">-- Select Bilboard Type --</option>
                                @foreach ($billboardTypes as $prefix => $type)
                                    <option value="{{ $prefix }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Billboard Size</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardSize">
                                <option value="">-- Select Size --</option>
                                @foreach ($billboardSize as $size)
                                    <option value="{{ $size }}">{{ $size }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Lighting</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardLighting">
                                <option value="">-- Select Lighting --</option>
                                @foreach ($billboardLighting as $lighting)
                                    <option value="{{ $lighting }}">{{ $lighting }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>State</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardState">
                                <option value="">-- Select State --</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>District</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardDistrict">
                                <option value="">-- Select District --</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Area</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardLocation">
                                <option value="">-- Select Area --</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="start_date" class="form-label">GPS Longitude</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="editGPSLongitude" value="" required>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label for="end_date" class="form-label">GPS Latitude</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="editGPSLatitude" value="" required>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Traffic Volume</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="editBillboardTrafficVolume" value="" required>
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
<script>
    $('#filterBillboardState').on('change', function () {
        let stateId = $(this).val();

        // Reset district dropdown
        $('#filterBillboardDistrict').empty().append('<option value="all">All</option>');

        if (stateId !== 'all') {
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

    
    
    $(document).ready(function() {
        // Global variables
        var filterBillboardSupervisor;
        var filterBillboardTechnician;
        var filterBillboardStatus;
        var originalWorkOrderIdEdit;
        var originalWorkOrderIdStatusUpdate;
        var originalWorkOrderId;

        document.getElementById("billboardDeleteButton").addEventListener("click", billboardDeleteButton);


        // When "State" is changed in add form
        $('#inputBillboardState').on('change', function () {
            let stateId = $(this).val();

            // Reset District and Location dropdowns
            $('#inputBillboardDistrict').empty().append('<option value="">-- Select District --</option>');
            $('#inputBillboardLocation').empty().append('<option value="">-- Select Location --</option>');

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
            let districtId = $(this).val();

            // Reset Location dropdown
            $('#inputBillboardLocation').empty().append('<option value="">-- Select Location --</option>');

            if (districtId !== '') {
                $.ajax({
                    url: '{{ route("location.getLocations") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        district_id: districtId
                    },
                    success: function (locations) {
                        locations.forEach(function (location) {
                            $('#inputBillboardLocation').append(`<option value="${location.id}">${location.name}</option>`);
                        });
                    },
                    error: function () {
                        alert('Failed to load locations.');
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
                    [0, 'desc']
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
                        data: "WO_detail",
                        render: function(data, type, row) {
                            var a = "{{ route('workOrderProfile.index', ['id'=>':data'] )}}".replace(':data', data);
                            let element = 
                                `<div class="flex flex-row">
                                    <a href="javascript:;" id="profile-` + data + `"
                                        class="button w-24 inline-block mr-2 mb-2 bg-theme-9 text-white" data-toggle="button" onclick="window.open('${a}')" >
                                        Details
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
                                    data-type="${row.type}"
                                    data-size="${row.size}"
                                    data-lighting="${row.lighting}"
                                    data-state_id="${row.state_id}"
                                    data-district_id="${row.district_id}"
                                    data-location_id="${row.location_id}"
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
                // createdRow: function(row, data, dataIndex) {
                //     $(row).attr('data-id', data.id);
                //     $(row).attr('data-type', data.type);
                //     $(row).attr('data-size', data.size);
                //     $(row).attr('data-lighting', data.lighting);
                //     $(row).attr('data-state_id', data.state_id);
                //     $(row).attr('data-district_id', data.district_id);
                //     $(row).attr('data-location_id', data.location_id);
                //     $(row).attr('data-prefix', data.prefix);
                // },
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

            // Set values
            $('#editBillboardType').val($this.data('type'));
            $('#editBillboardSize').val($this.data('size'));
            $('#editBillboardLighting').val($this.data('lighting'));

            // Set state and load districts
            const stateID = $this.data('state_id');
            const districtID = $this.data('district_id');
            const locationID = $this.data('location_id');

            $('#editBillboardState').val(stateID).trigger('change');

            $.post('{{ route("location.getDistricts") }}', {
                _token: '{{ csrf_token() }}',
                state_id: stateID
            }, function (districts) {
                $('#editBillboardDistrict').empty().append(`<option value="">-- Select District --</option>`);
                districts.forEach(function (d) {
                    $('#editBillboardDistrict').append(`<option value="${d.id}">${d.name}</option>`);
                });
                $('#editBillboardDistrict').val(districtID).trigger('change');

                // Load locations
                $.post('{{ route("location.getLocations") }}', {
                    _token: '{{ csrf_token() }}',
                    district_id: districtID
                }, function (locations) {
                    $('#editBillboardLocation').empty().append(`<option value="">-- Select Location --</option>`);
                    locations.forEach(function (l) {
                        $('#editBillboardLocation').append(`<option value="${l.id}">${l.name}</option>`);
                    });
                    $('#editBillboardLocation').val(locationID);
                });
            });

            // Open modal
            openAltEditorModal("#billboardEditModal");
        });

        // On State change => fetch districts
        $('#editBillboardState').on('change', function () {
            let stateID = $(this).val();
            $('#editBillboardDistrict').html('<option value="">-- Loading Districts --</option>');
            $('#editBillboardLocation').html('<option value="">-- Select Location --</option>');

            if (stateID) {
                $.get('/get-districts/' + stateID, function (data) {
                    let options = '<option value="">-- Select District --</option>';
                    data.forEach(function (district) {
                        options += `<option value="${district.id}">${district.name}</option>`;
                    });
                    $('#editBillboardDistrict').html(options);
                });
            }
        });

        // On District change => fetch locations
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

            document.getElementById("billboardAddButton").disabled = true;
            document.getElementById('billboardAddButton').style.display = 'none';

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
                    location        : document.getElementById("inputBillboardLocation").value,
                    gpslongitude    : document.getElementById("inputGPSLongitude").value,
                    gpslatitude     : document.getElementById("inputGPSLatitude").value,
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
                    document.getElementById("inputBillboardLocation").value = "";
                    document.getElementById("inputGPSLongitude").value = "";
                    document.getElementById("inputGPSLatitude").value = "";
                    document.getElementById("inputBillboardTrafficVolume").value = "";

                    // Reload table
                    $('#billboard_table').DataTable().ajax.reload();
                    
                    // Reset the button visibility and enable it for next submission
                    document.getElementById("billboardAddButton").disabled = false;
                    document.getElementById('billboardAddButton').style.display = 'inline-block';  // Shows the button again
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

        function billboardEditModal() {
    $(document).off('click', "[id^='edit-']");

    $(document).on('click', "[id^='edit-']", function (event) {
        event.preventDefault();

        // Get the billboard ID (if needed for further AJAX)
        let billboardID = $(this).attr('id').split('-')[1];

        // Get the parent row
        let row = $(this).closest('tr');

        // Extract values from data attributes
        let prefix     = row.attr('data-prefix') || "";
        let size       = row.attr('data-size') || "";
        let lighting   = row.attr('data-lighting') || "";
        let stateID    = row.attr('data-state_id') || "";
        let districtID = row.attr('data-district_id') || "";
        let locationID = row.attr('data-location_id') || "";

        // Fill static dropdowns
        $('#editBillboardType').val(prefix);
        $('#editBillboardSize').val(size);
        $('#editBillboardLighting').val(lighting);

        // Set state and trigger change to load districts
        $('#editBillboardState').val(stateID).trigger('change');

        // Chain select population after change events
        setTimeout(() => {
            $('#editBillboardDistrict').val(districtID).trigger('change');

            setTimeout(() => {
                $('#editBillboardLocation').val(locationID);
            }, 300);
        }, 300);

        // Show the modal
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

































        // Open modal to edit Billboard
        function workOrderEditModal() {            
            // Remove previous click event listeners
            $(document).off('click', "[id^='billboard_table'] tbody tr td:not(:nth-last-child(2)):not(:last-child)");

            $(document).on('click', "[id^='billboard_table'] tbody tr td:not(:nth-last-child(2)):not(:last-child)", function() {
                // Grab row client company id
                originalWorkOrderIdEdit = $(event.target).closest('tr').find('td:nth-last-child(2) a').attr('id').split('-')[1];

                // Place values to edit form fields in the modal
                document.getElementById("workOrderEditPriority").value = $(event.target).closest('tr').find('td:nth-child(' + '5' + ')').text();
                
                // Open modal
                var element = "#workOrderEditModal";
                openAltEditorModal(element);
            });
        };

        //Edit Billboard
        function editWorkOrder() {
            var statusUpdated ;
            var priority = document.getElementById("workOrderEditPriority").value;

            statusUpdated = ((document.getElementById("workOrderAssignTechnician").value) ? 'STARTED'
                : null 
            );

            $.ajax({
                type: 'POST',
                url: "{{ route('billboard.edit') }}",
                data: {
                    _token                  : $('meta[name="csrf-token"]').attr('content'),
                    priority                : priority,
                    original_workOrder_id   : originalWorkOrderIdEdit,
                },
                success: function(response) {
                    console.log(response);
                    // Close modal after successfully edited
                    var element = "#workOrderEditModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("workOrderEditPriority").value = "";

                    // Reload table
                    $('#billboard_table').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    // Display the validation error message
                    var response = JSON.parse(xhr.responseText);
                    var error    = "Error: " + response.error;

                    // Show fail toast
                    window.showSubmitToast(error, "#D32929");
                }
            });
        };
        
        //Update Billboard status
        function updateStatusWorkOrder(){
            var updateStatus ;
            var assignedTechnician = null;
            
            if(document.getElementById("workOrderAssignTechnician").value) {
                //Assign technician and update Billboard status to STARTED
                updateStatus   = 'STARTED';
                assignedTechnician     = document.getElementById("workOrderAssignTechnician").value ;

            } 
            else if(document.getElementById("workOrderStatusUpdate").value) {
                //Update Billboard status to VERIFICATION_PASSED/VERIFICATION_FAILED
                updateStatus   = 'COMPLETED';
                // statusValue     = document.getElementById("workOrderStatusUpdate").value ;

            } 
            else {
                // Show fail toast
                window.showSubmitToast("Error: No option is selected. Please select one.", "#D32929") ;
            }

            if(updateStatus || assignedTechnician) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('billboard.update') }}",
                    data: {
                        _token                  : $('meta[name="csrf-token"]').attr('content'),
                        update_status           : updateStatus,
                        assigned_technician     : assignedTechnician ? assignedTechnician : null,
                        original_workOrder_id   : originalWorkOrderIdStatusUpdate,
                    },
                    success: function(response) {
                        console.log(response);
                        if(updateStatus == 'STARTED') {
                            var modalElement = "#workOrderAssignTcModal" ;
                            var elementId    = "workOrderAssignTechnician" ;

                        } 
                        else if(updateStatus == 'COMPLETED') {
                            var modalElement = "#workOrderStatusUpdateModal" ;
                            var elementId    = "workOrderStatusUpdate" ;
                        }

                        // Close modal after successfully edited
                        closeAltEditorModal(modalElement);
    
                        // Show successful toast
                        window.showSubmitToast((response.message) ? response.message : "Successfully added.", "#91C714");
    
                        // Clean fields
                        document.getElementById(elementId).value = "";
    
                        // Reload table
                        $('#billboard_table').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        // Display the validation error message
                        var response = JSON.parse(xhr.responseText);
                        var error    = "Error: " + response.error;
    
                        // Show fail toast
                        window.showSubmitToast(error, "#D32929");
                    }
                });
            }
        };

        // Store the ID of the last clicked modal when it's triggered
        (function() {
            $(document).on('click', "[data-toggle='modal']", function() {
                lastClickedLink = $(this).attr('id');
            });
        })();
    });
</script>
@endsection('script')
