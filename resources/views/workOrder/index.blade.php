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
    
    <!-- BEGIN: Work Order Filter-->
    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
        <form class="xl:flex sm:mr-auto">
            <div class="sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Status</label>
                <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputOnGoingWorkOrderStatus">
                    <option value="all">All</option>
                    <option value="new">New</option>
                    <option value="started">Started</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            @if (Auth::guard('web')->user()->hasRole(['superadmin', 'employee_occ_admin', 'employee_occ_operator']))
            <div class="sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">State</label>
                <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputOnGoingWorkOrderStatus">
                    <option value="all">All</option>
                    <option value="new">Selangor</option>
                    <option value="started">Kuala Lumpur</option>
                    <option value="completed">Perak</option>
                </select>
            </div>
            

            <div class="sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">District</label>
                <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputOnGoingWorkOrderStatus">
                    <option value="all">All</option>
                    <option value="new">Petaling jaya</option>
                    <option value="started">Subang Jaya</option>
                    <option value="completed">Ampang</option>
                </select>
            </div>

            <br>

            <div class="sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Type</label>
                <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputOnGoingWorkOrderStatus">
                    <option value="all">All</option>
                    <option value="new">Billboard</option>
                    <option value="started">Tempboard</option>
                    <option value="completed">Bunting</option>
                    <option value="completed">Banner</option>
                </select>
            </div>

            <div class="sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Size</label>
                <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputOnGoingWorkOrderStatus">
                    <option value="all">All</option>
                    <option value="new">30 X 30</option>
                    <option value="started">30 X 20</option>
                    <option value="completed">20 X 10</option>
                    <option value="completed">40 X 50</option>
                </select>
            </div>
            @endif

            <div class="mt-2 xl:mt-0">
                <button type="button" class="button w-full sm:w-16 bg-theme-32 text-white" id="filterOnGoingWorkOrderButton">Filter</button>
            </div>
        </form>

        <div class="text-center"> 
            <a href="javascript:;" data-toggle="modal" data-target="#addBillboardBookingModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add New Billboard
            </a> 
        </div> 
    </div>
    <!-- END:  Work Order Filter -->

    <!-- BEGIN: Work Order List -->
    <!-- <div class="overflow-x-auto scrollbar-hidden">
        <table class="table table-report mt-5" id="onGoingWorkOrder_table">
            <thead>
                <tr class="bg-theme-1 text-white">
                    <th>Work Order No</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Status</th> 
                    <th>Priority</th>
                    <th>Created At</th>
                    <th>Due Date</th>
                    <th>Team Leader Assigned</th>
                    <th>Technician Assigned</th>
                    <th class="dt-exclude-export dt-no-sort">Show Detail</th>
                    <th class="dt-exclude-export dt-no-sort">Actions</th>
                </tr>
            </thead>
        </table>
    </div> -->
    <!-- END: Work Order List -->
    <!-- BEGIN: Work Order List -->
    <div class="overflow-x-auto scrollbar-hidden">
        <table class="table table-report mt-5" id="onGoingWorkOrder_table">
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
    <!-- END: Work Order List -->
</div>
@endsection('app_content')

@section('modal_content')
<!-- Create Modal -->
    <div class="row flex flex-col sm:flex-row sm:items-end xl:items-start mb-2">
        <div class="modal" id="addBillboardBookingModal">
            <div class="modal__content">
                <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">Add New Billboard</h2>
                </div>
                <form>
                    <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label>Billboard Type</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputOnGoingWorkOrderStatus">
                                <option value="">-- Select Bilboard Type --</option>
                                <option value="new">Billboard</option>
                                <option value="started">Temp Board</option>
                                <option value="completed">Bunting</option>
                                <option value="completed">Banner</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Billboard Size</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputOnGoingWorkOrderStatus">
                                <option value="new">30 X 20</option>
                                <option value="started">50 X 40</option>
                                <option value="completed">10 X 20</option>
                                <option value="completed">50 X 50</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Lighting</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputOnGoingWorkOrderStatus">
                                <option value="new">LED</option>
                                <option value="started">Solar</option>
                                <option value="completed">No lighting</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>State</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputOnGoingWorkOrderStatus">
                                <option value="">-- Select State --</option>
                                <option value="new">Selangor</option>
                                <option value="started">Kuala Lumpur</option>
                                <option value="completed">Perak</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>District</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputOnGoingWorkOrderStatus">
                                <option value="">-- Select District --</option>
                                <option value="new">Petaling Jaya</option>
                                <option value="started">Subang Jaya</option>
                                <option value="completed">Ampang</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Location</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputOnGoingWorkOrderStatus">
                                <option value="">-- Select Location --</option>
                                <option value="new">Taman Mayang 1</option>
                                <option value="started">Taman Mayang 2</option>
                                <option value="completed">Ampang Park</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="start_date" class="form-label">GPS Longitude</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="ServiceRequestAddDescription" value="" required>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label for="end_date" class="form-label">GPS Latitude</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="ServiceRequestAddDescription" value="" required>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Traffic Volume</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="ServiceRequestAddDescription" value="" required>
                        </div>
                    </div>

                    <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                        <button type="submit" class="button w-20 bg-theme-1 text-white" id="ServiceRequestAddButton">Submit</button>
                    </div>
                </form>
            </div>
        </div> 
    </div>
<!-- Create Modal End -->


<!-- BEGIN: Work Order Edit Modal -->
<div class="modal" id="workOrderEditModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Edit Work Order</h2>
        </div>    
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Priority</label>
                    <select class="input w-full border mt-2 flex-1" placeholder="Priority" id="workOrderEditPriority" required>
                        <option value="1">1 - in 15 days</option>
                        <option value="2">2 - in 30 days</option>
                        <option value="3">3 - in 60 days</option>
                        <option value="4">4 - in 70 days</option>
                    </select>
                </div>
            </div>

            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="workOrderEditButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Work Order Edit Modal -->

<!-- BEGIN: Work Order Status Update Modal -->
<div class="modal" id="workOrderStatusUpdateModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Update Work Order Status</h2>
        </div>    
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Status</label>
                    <select class="input w-full border mt-2 flex-1" id="workOrderStatusUpdate" required>
                        <option value="" disabled selected hidden>Completed</option>
                        <option value="COMPLETED">Completed</option>
                        <!-- <option value="VERIFICATION_FAILED">Verification Failed</option> -->
                    </select>
                </div>
            </div>

            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="workOrderStatusUpdateButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Work Order Status Update Modal -->

<div class="modal" id="workOrderAssignSVModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Assign Workforce</h2>
        </div>

        <div class="px-5 py-2 text-right border-t border-gray-200 dark:border-dark-2">
            <button type="submit" class="button w-20 bg-theme-1 text-white" id="assignSubmitSVButton">Submit</button>
        </div>
    </div>
</div>

<div class="modal" id="workOrderAssignTcModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Assign Workforce</h2>
        </div>

        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Technician</label>
                    <select class="input w-full border mt-2 flex-1" placeholder="Technician ID" id="workOrderAssignTechnician" required>
                        <option disabled selected hidden value>Select an option</option>
                        @foreach ($technicians as $technician)
                        <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        <div class="px-5 py-2 text-right border-t border-gray-200 dark:border-dark-2">
            <button type="submit" class="button w-20 bg-theme-1 text-white" id="assignSubmitTcButton">Submit</button>
        </div>
    </div>
</div>
@endsection('modal_content')

@section('script')
<script>
    $(document).ready(function() {
        // Global variables
        var filterOnGoingWorkOrderSupervisor;
        var filterOnGoingWorkOrderTechnician;
        var filterOngoingWorkOrderStatus;
        var originalWorkOrderIdEdit;
        var originalWorkOrderIdStatusUpdate;
        var originalWorkOrderId;
        
        // Listen to below buttons
        document.getElementById("filterOnGoingWorkOrderButton").addEventListener("click", filterOnGoingWorkOrderButton);

        // When "filterOnGoingWorkOrderButton" button is clicked, initiate initOnGoingWorkOrderDatatable
        function filterOnGoingWorkOrderButton() {
            // filterOnGoingWorkOrderSupervisor = (document.getElementById("inputOnGoingWorkOrderSupervisor")) ? document.getElementById("inputOnGoingWorkOrderSupervisor").value : 'all';
            // filterOnGoingWorkOrderTechnician = (document.getElementById("inputOnGoingWorkOrderTechnician")) ? document.getElementById("inputOnGoingWorkOrderTechnician").value : 'all';
            filterOnGoingWorkOrderStatus     = document.getElementById("inputOnGoingWorkOrderStatus").value;
            filterOnGoingWorkOrderTechnician     = (document.getElementById("inputOnGoingWorkOrderTechnician")) ? document.getElementById("inputOnGoingWorkOrderTechnician").value : 'all';
            filterOnGoingWorkOrderTeamLeader     = (document.getElementById("inputOnGoingWorkOrderTeamLeader")) ? document.getElementById("inputOnGoingWorkOrderTeamLeader").value : 'all';

            initOnGoingWorkOrderDatatable(filterOnGoingWorkOrderTeamLeader, filterOnGoingWorkOrderTechnician, filterOnGoingWorkOrderStatus);
        };

        // When page first loads, load table
        filterOnGoingWorkOrderButton();

        // When any submit button is clicked
        (function() {
            var workOrder_table = $('#onGoingWorkOrder_table')[0].altEditor;
            var workOrderAssignModal = 'workOrderAssignModal';

            @if (Auth::guard('web')->user()->can('work_order.edit'))
            document.getElementById('workOrderEditButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Edit client company
                editWorkOrder();
            });
            @endif

            @if (Auth::guard('web')->user()->hasRole(['superadmin', 'employee_occ_admin', 'employee_occ_operator']))
            document.getElementById('assignSubmitSVButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Edit client company
                //assignWorkOrder();
                updateStatusWorkOrder();
            });
            @endif

            @if (Auth::guard('web')->user()->hasRole(['superadmin', 'team_leader']))
            document.getElementById('assignSubmitTcButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Edit client company
                //assignWorkOrder();
                updateStatusWorkOrder();
            });

            document.getElementById('workOrderStatusUpdateButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Edit client company
                updateStatusWorkOrder();
            });
            @endif

        })();

        //Store the ID of the last clicked update status modal when it's triggered
        (function() {
            $(document).on('click', "[data-target='#workOrderStatusUpdateModal'], [data-target='#workOrderAssignTcModal']", function() {
                originalWorkOrderIdStatusUpdate = ($(this).attr('id')).split("-")[2];
                // console.log(originalWorkOrderIdStatusUpdate);
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

        // Setup the on-going work order datatable
        function initOnGoingWorkOrderDatatable() {
            const dt            = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName     = `Contract_List_${formattedDate}_${formattedTime}`;

            const table = $('#onGoingWorkOrder_table').DataTable({
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
                    url: "{{ route('workOrder.list') }}",
                    dataType: "json",
                    type: "POST",
                    method:"POST",
                    data: function(d) {
                        d._token        = $('meta[name="csrf-token"]').attr('content');
                        d.teamleader    = filterOnGoingWorkOrderTeamLeader;
                        d.technician    = filterOnGoingWorkOrderTechnician;
                        d.status        = filterOnGoingWorkOrderStatus;

                        return d;
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
                        data: "work_order_no",
                    },
                    {
                        data: "type",
                    },
                    {
                        data: "type",
                    },
                    {
                        data: "type",
                    },
                    {
                        data: "work_order_no",
                    },
                    {
                        data: "work_order_no",
                    },
                    {
                        data: "created_at",
                    },
                    {
                        data: "status",
                        type: "readonly",
                        render: function(data, type, row) {
                            let element = ``
                            if (data == 'NEW'){
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-12 text-white">` + data + `</a>`;
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-12 text-white">REGISTERED</a>`;
                            } else if (data == 'STARTED') {
                                // element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 border text-gray-700 dark:border-dark-5 dark:text-gray-300">YEET</a>`;
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-18 text-black">ACTIVE</a>`;
                            } else if (data == 'COMPLETED'){
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-1 text-white">INACTIVE</a>`;
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
                                <a href="javascript:;" id="profile-` + data + `"
                                    class="button w-24 inline-block mr-2 mb-2 bg-theme-1 text-white" data-toggle="button"" >
                                    Edit
                                </a>

                                <!-- Delete Button -->
                                <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#clientUsersDeleteModal" id="delete-client-` + data + `">
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
            });

            // Add classes to the "dt-buttons" div
            var dtButtonsDiv = document.querySelector(".dt-buttons");
            if (dtButtonsDiv) {
                dtButtonsDiv.classList.add("mt-2");
            }

            // Update styling for the filter input
            var filterDiv = document.getElementById("onGoingWorkOrder_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv     = document.getElementById("onGoingWorkOrder_table_info");
            var paginateDiv = document.getElementById("onGoingWorkOrder_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "onGoingWorkOrder_table_length" div and its select element
            var existingDiv = document.getElementById("onGoingWorkOrder_table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }

            @if (Auth::guard('web')->user()->can('work_order.edit'))
            // Open modal to edit work order
            workOrderEditModal();
            @endif
        };

        // Open modal to edit work order
        function workOrderEditModal() {            
            // Remove previous click event listeners
            $(document).off('click', "[id^='onGoingWorkOrder_table'] tbody tr td:not(:nth-last-child(2)):not(:last-child)");

            $(document).on('click', "[id^='onGoingWorkOrder_table'] tbody tr td:not(:nth-last-child(2)):not(:last-child)", function() {
                // Grab row client company id
                originalWorkOrderIdEdit = $(event.target).closest('tr').find('td:nth-last-child(2) a').attr('id').split('-')[1];

                // Place values to edit form fields in the modal
                document.getElementById("workOrderEditPriority").value = $(event.target).closest('tr').find('td:nth-child(' + '5' + ')').text();
                
                // Open modal
                var element = "#workOrderEditModal";
                openAltEditorModal(element);
            });
        };

        //Edit work order
        function editWorkOrder() {
            var statusUpdated ;
            var priority = document.getElementById("workOrderEditPriority").value;

            statusUpdated = ((document.getElementById("workOrderAssignTechnician").value) ? 'STARTED'
                : null 
            );

            $.ajax({
                type: 'POST',
                url: "{{ route('workOrder.edit') }}",
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
                    $('#onGoingWorkOrder_table').DataTable().ajax.reload();
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
        
        //Update work order status
        function updateStatusWorkOrder(){
            var updateStatus ;
            var assignedTechnician = null;
            
            if(document.getElementById("workOrderAssignTechnician").value) {
                //Assign technician and update work order status to STARTED
                updateStatus   = 'STARTED';
                assignedTechnician     = document.getElementById("workOrderAssignTechnician").value ;

            } 
            else if(document.getElementById("workOrderStatusUpdate").value) {
                //Update work order status to VERIFICATION_PASSED/VERIFICATION_FAILED
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
                    url: "{{ route('workOrder.update') }}",
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
                        $('#onGoingWorkOrder_table').DataTable().ajax.reload();
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
