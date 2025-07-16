@extends('layouts.main')

@section('title')
<title>Chulia Middle East - Service Request</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Service Request
    </h2>
</div>
<div class="intro-y box p-5 mt-5">
    <div class="mb-5 p-5 rounded-md" style="background-color:#ECF9FD;">
        <h2 class="text-lg font-medium">
            Service Request
        </h2>
        <p class="w-12 flex-none xl:w-auto xl:flex-initial ml-2">
            <i class="font-bold">Service Request</i> - Lorem Ipsum.
        </p>
    </div>
    <!-- Create Modal -->
    <div class="row flex flex-col sm:flex-row sm:items-end xl:items-start mb-2">
        <div class="modal" id="addServiceRequestModal">
            <div class="modal__content">
                <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">Add Service Request</h2>
                </div>
                <form>
                    <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                            <label>Project</label>
                            <select class="input w-full border mt-2 flex-1" id="ServiceRequestAddProject" required>
                                <option disabled selected hidden value>Select a project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->project_prefix }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Description</label>
                            <input type="text" class="input w-full border mt-2 flex-1" placeholder="Enter a Description" id="ServiceRequestAddDescription" required>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Client Remark</label>
                            <input type="text" class="input w-full border mt-2 flex-1" placeholder="Enter a Client Remark" id="ServiceRequestAddClientRemark" required>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Priority</label>
                            <select class="input w-full border mt-2 flex-1" id="ServiceRequestAddPriority" required>
                                <option value="" disabled selected hidden value>Select Priority</option>
                                <option value="1">Low</option>
                                <option value="2">Medium</option>
                                <option value="3">High</option>
                                <option value="4">Very High</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Category</label>
                            <select class="input w-full border mt-2 flex-1" id="ServiceRequestAddCategory" required>
                                <option disabled selected hidden value>Select a category</option>
                                @foreach ($mainCategory as $maincategory)
                                    <option value="{{ $maincategory->id }}">{{ $maincategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Sub Category</label>
                            <select class="input w-full border mt-2 flex-1" id="ServiceRequestAddSubCategory" required>
                                <option disabled selected hidden value>Select a sub category</option>
                                {{-- @foreach ($subCategory as $subcategory)
                                    <option value="{{ $subcategory->sr_category_id }}">{{ $subcategory->name }}</option>
                                @endforeach --}}
                            </select>
                        </div>

                        {{-- <div class="col-span-12 sm:col-span-12">
                            <label>Employee Name</label>
                            <select class="input w-full border mt-2 flex-1" id="inhouseUsersAddEmployee" required>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Password</label>
                            <input type="password" class="input w-full border mt-2 flex-1" placeholder="Password" id="inhouseUsersAddPassword" required>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Password Confirmation</label>
                            <input type="password" class="input w-full border mt-2 flex-1" placeholder="Password" id="inhouseUsersAddPasswordConfirmation" required>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Email</label>
                            <input type="email" class="input w-full border mt-2 flex-1" placeholder="example@gmail.com" id="inhouseUsersAddEmail" required>
                        </div> --}}
                    </div>

                    <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                        <button type="submit" class="button w-20 bg-theme-1 text-white" id="ServiceRequestAddButton">Submit</button>
                    </div>
                </form>
            </div>
        </div> 
    </div>
    <!-- Modal End -->
    <!-- Table Filter -->
    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start mb-2 mt-2">
        <form class="xl:flex sm:mr-auto" id="employee_table">
            <div class="row sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Company</label>
                <select class="input w-full mt-2 sm:mt-0 sm:w-auto border" id="inputCompany">
                    <option value="All">All</option>
                    <option value="Org1">Org1</option>
                </select>
            </div>
            <div class="row sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Role</label>
                    <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputEmployeeRole">
                        <option value="All">All</option>
                        <option value="superadmin">Superadmin</option>
                        <option value="teamleader">Team Leader</option>
                        <option value="Employee_OCC_Operator">OCC Operator</option>
                        <option value="Employee_Supervisor">In-House Supervisor</option>
                        <option value="Employee_Technician">In-House Technician</option>
                    </select>
            </div>
            <div class="row sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Service Request<br>Status</label>
                <select class="input w-full mt-2 sm:mt-0 sm:w-auto border" id="inputServiceRequestStatus">
                    <option value="All" selected="">All</option>
                    <option value="NEW">New</option>
                    <option value="ACCEPTED">Accepted</option>
                    <option value="CLOSED">Closed</option>
                    <option value="REJECTED">Rejected</option>
                </select>
            </div>
            <div class="mt-2 xl:mt-0">
                <button type="button" class="button w-full sm:w-16 bg-theme-1 text-white" id="filterServiceRequestButton">Filter</button>
            </div>
        </form>

        <div class="text-center"> 
            <a href="javascript:;" data-toggle="modal" data-target="#addServiceRequestModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add New Service Request
            </a> 
        </div> 
    </div>
    <!-- Filter End -->
    <!-- Service Request table -->
    <div class="overflow-x-auto scrollbar-hidden">
        <table class="table mt-5" id="service_request_table">
            <thead>
                <tr class="bg-theme-1 text-white">
                    <th class="whitespace-nowrap">#</th>
                    <th class="whitespace-nowrap">Service Request No.</th>
                    <th class="whitespace-nowrap">Description</th>
                    <th class="whitespace-nowrap">Client Remark</th>
                    <th class="whitespace-nowrap">Team Leader Remark</th>
                    <th class="whitespace-nowrap">Location</th> 
                    <th class="whitespace-nowrap">Status</th>
                    <th class="whitespace-nowrap">Raised by</th>
                    <th class="whitespace-nowrap">Created At</th>
                    <th class="whitespace-nowrap">Work Order</th>
                    <th class="whitespace-nowrap flex flex-row">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <!-- Table End -->
    <!-- TODO: add logics here to view list of srevice requests for destroy|update|edit included within a modal -->
</div>
@endsection('app_content')

@section('modal_content')
<!-- BEGIN: Service Request Reject Modal -->
<div class="modal" id="serviceRequestRejectModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm rejecting this service request? This process cannot be undone.</div>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Reject Reason</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Reject Reason" id="serviceRequestRejectReason" required>
                </div>
            </div>

            <!-- <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="serviceRequestEditButton">Update</button>
            </div> -->
        </form>

        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="serviceRequestRejectButton" onclick="serviceRequestRejectButton()">Reject</button>
        </div>
    </div>
</div>
<!-- END: Service Request Reject Modal -->

<!-- BEGIN: Service Request Delete Modal -->
<div class="modal" id="serviceRequestDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm delete this service request? This process cannot be undone.</div>
        </div>

        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="serviceRequestDeleteButton" onclick="serviceRequestDeleteButton()">Delete</button>
        </div>
    </div>
</div>
<!-- END: Service Request Reject Modal -->

<!-- BEGIN: SR Edit Modal -->
<div class="modal" id="serviceRequestEditModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Edit Service Request</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Description</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Description" id="serviceRequestEditDescription" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Client Remark</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Client Remark" id="serviceRequestEditClientRemark" required>
                </div>
            </div>

            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="serviceRequestEditButton">Update</button>
            </div>
        </form>
    </div>
</div>
<!-- END: SR Edit Modal -->
@endsection('modal_content')

@section('script')
<script>
    	
    $(document).ready(function() {

        // Global variables
        var filterServiceRequestStatus;
        var originalServiceRequestId;
        var lastClickedLink;

        // Listen to below buttons
        document.getElementById("filterServiceRequestButton").addEventListener("click", filterServiceRequestButton);
        document.getElementById("serviceRequestRejectButton").addEventListener("click", serviceRequestRejectButton);
        document.getElementById("serviceRequestDeleteButton").addEventListener("click", serviceRequestDeleteButton);
        document.getElementById("ServiceRequestAddButton").addEventListener("click", ServiceRequestAddButton);
        // document.getElementById("openWorkOrderDetailButton").addEventListener("click", openWorkOrderDetail);

        // When "filterServiceRequestButton" button is clicked, initiate initInHouseUsersDatatable
        function filterServiceRequestButton() {
            filterServiceRequestStatus = document.getElementById("inputServiceRequestStatus").value;
            initInHouseUsersDatatable(filterServiceRequestStatus);
        };

        // When page first loads, load the in-house users table
        filterServiceRequestButton();

        // Store the ID of the last clicked modal when it's triggered
        (function() {
            $(document).on('click', "[data-toggle='modal']", function() {
                lastClickedLink = $(this).attr('id');
            });
        })();

        $(document).ready(function() {
            $('#ServiceRequestAddCategory').on('change', function() {
                var sr_category_id = $(this).val();
                if(sr_category_id) {
                    $.ajax({
                        url: '/get-subcategories/'+sr_category_id,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('#ServiceRequestAddSubCategory').empty();
                            $('#ServiceRequestAddSubCategory').append('<option disabled selected hidden value>Select a sub category</option>');
                            $.each(data, function(key, value) {
                                $('#ServiceRequestAddSubCategory').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                            });
                        }
                    });
                } else {
                    $('#ServiceRequestAddSubCategory').empty();
                    $('#ServiceRequestAddSubCategory').append('<option disabled selected hidden value>Select a category first</option>');
                }
            });
        });

        // When any submit button is clicked
        (function() {
            var service_request_table = $('#service_request_table')[0].altEditor;

            document.getElementById('ServiceRequestAddButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();
            });

            document.getElementById('serviceRequestRejectButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();
            });

            document.getElementById('serviceRequestDeleteButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();
            });

            document.getElementById('serviceRequestEditButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Edit SR
                editServiceRequest();
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

        // Edit SR 
        function editServiceRequest() {
            var description = document.getElementById("serviceRequestEditDescription").value;
            var client_remark = document.getElementById("serviceRequestEditClientRemark").value;

            $.ajax({
                type: 'POST',
                url: "{{ route('serviceRequest.edit') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    desc: description,
                    client_remark: client_remark,
                    id: originalServiceRequestId,
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#serviceRequestEditModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully updated.", "#91C714");

                    // Clean fields
                    document.getElementById("serviceRequestEditDescription").value = "";
                    document.getElementById("serviceRequestEditClientRemark").value = "";

                    // Reload table
                    $('#service_request_table').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    // Display the validation error message
                    var response = JSON.parse(xhr.responseText);
                    var error = "Error: " + response.error;

                    // Show fail toast
                    window.showSubmitToast(error, "#D32929");
                }
            });
        }
    
        // Setup the in-house users datatable
        function initInHouseUsersDatatable() {
            const dt = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName = `Employee_List_${formattedDate}_${formattedTime}`;

            const table = $('#service_request_table').DataTable({
                altEditor: true,
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
                    url: "{{ route('serviceRequest.list.index') }}",
                    dataType: "json",
                    type: "POST",
                    data: function(d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        d.service_request_status = filterServiceRequestStatus;
                        return d;
                    },
                    dataSrc: function(json) {
                        json.recordsTotal = json.recordsTotal;
                        json.recordsFiltered = json.recordsFiltered;
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
                            stripHtml: false,
                        },
                        init: function(api, node, config) {
                            $(node).removeClass('dt-button');
                            $(node).removeClass('buttons-html5');
                        },
                    },
                ],
                
                columns: [
                    {
                        data: "id",
                    },
                    {
                        data: "service_request_no",
                    },
                    {
                        data: "description",
                    },
                    {
                        data: "client_remark",
                    },
                    {
                        data: "teamleader_remark",
                    },
                    {
                        data: "location",
                    },
                    {
                        data: "status",
                        type: "readonly",
                        render: function(data, type, row) {
                            let element = ``
                            if (data == 'NEW'){
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-12 text-white">` + data + `</a>`;
                            } else if (data == 'ACCEPTED') {
                                // element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 border text-gray-700 dark:border-dark-5 dark:text-gray-300">YEET</a>`;
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-18 text-black">` + data + `</a>`;
                            } else if (data == 'CLOSED'){
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-1 text-white">` + data + `</a>`;
                            } else if (data == 'REJECTED'){
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-6 text-white">` + data + `</a>`;
                            }
                            
                            return element;
                        }
                    },
                    {
                        data: "user_raise",
                    },
                    {
                        data: "created_at",
                    },
                    
                    {
                        data: "WO_detail",
                        render: function(data, type, row) {
                            var a = "{{ route('workOrderProfile.index', ['id'=>':data'] )}}".replace(':data', data);
                            let element = 
                            `<div class="flex flex-row">
                                <a href="javascript:;" id="profile-` + data + `"
                                    class="button w-24 inline-block mr-2 mb-2 bg-theme-9 text-white" data-toggle="button" onclick="window.open('${a}')" >
                                    View Detail
                                </a>
                            </div>`;

                            return element;
                        }
                    },
                    {
                        data: "action",
                        render: function(data, type, row) {
                            let element = ``;
                            
                            // Check if the status is 'NEW'
                            if (row.status === 'NEW') {
                                // Show "Reject" button if the user is superadmin or teamleader
                                element = `@if (Auth::guard('web')->user()->hasRole(['superadmin', 'team_leader']))
                                            <a href="javascript:;" data-toggle="modal" data-target="#serviceRequestRejectModal" 
                                            id="reject-` + data + `"
                                            class="button w-24 inline-block mr-2 mb-2 bg-theme-6 text-white">
                                            Reject
                                            </a>
                                            @elseif (Auth::guard('web')->user()->hasRole('client_user'))
                                            <a href="javascript:;" data-toggle="modal" data-target="#serviceRequestDeleteModal" 
                                            id="delete-` + data + `"
                                            class="button w-24 inline-block mr-2 mb-2 bg-theme-6 text-white">
                                            Delete
                                            </a>
                                            @endif`;
                            }

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
            var filterDiv = document.getElementById("service_request_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv = document.getElementById("service_request_table_info");
            var paginateDiv = document.getElementById("service_request_table_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "service_request_table_length" div and its select element
            var existingDiv = document.getElementById("service_request_table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }

            // Open modal to edit SR
            serviceRequestEditModal();
        };

        // Open modal to edit SR
        function serviceRequestEditModal() {
            // Remove previous click event listeners
            $(document).off('click', "[id^='service_request_table'] tbody tr td:not(:last-child)");

            $(document).on('click', "[id^='service_request_table'] tbody tr td:not(:last-child)", function() {

                // Grab row client company id
                originalServiceRequestId = $(event.target).closest('tr').find('td:nth-last-child(2) a').attr('id').split('-')[1];

                // Place values to edit form fields in the modal
                document.getElementById("serviceRequestEditDescription").value = $(event.target).closest('tr').find('td:nth-child(' + '3' + ')').text();
                document.getElementById("serviceRequestEditClientRemark").value = $(event.target).closest('tr').find('td:nth-child(' + '4' + ')').text();

                // Open modal
                var element = "#serviceRequestEditModal";
                openAltEditorModal(element);
            });
        }

        var table = $('#table').DataTable({
            "dom": 'rtip',
            "paging":   false,
            "ordering": false,
            "info":     false
        });


        // Add New Service Request
        function ServiceRequestAddButton() {

            document.getElementById("ServiceRequestAddButton").disabled = true;
            document.getElementById('ServiceRequestAddButton').style.display = 'none';

            $.ajax({
                type: 'POST',
                url: "{{ route('serviceRequest.create') }}",
                data: {
                    _token      : $('meta[name="csrf-token"]').attr('content'),
                    project     : document.getElementById("ServiceRequestAddProject").value,
                    description : document.getElementById("ServiceRequestAddDescription").value,
                    remarks     : document.getElementById("ServiceRequestAddClientRemark").value,
                    priority    : document.getElementById("ServiceRequestAddPriority").value,
                    category    : document.getElementById("ServiceRequestAddCategory").value,
                    subcategory : document.getElementById("ServiceRequestAddSubCategory").value,
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#addServiceRequestModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("ServiceRequestAddProject").value = "";
                    document.getElementById("ServiceRequestAddDescription").value = "";
                    document.getElementById("ServiceRequestAddClientRemark").value = "";
                    document.getElementById("ServiceRequestAddPriority").value = "";
                    document.getElementById("ServiceRequestAddCategory").value = "";
                    document.getElementById("ServiceRequestAddSubCategory").value = "";

                    // Reload table
                    $('#service_request_table').DataTable().ajax.reload();
                    
                    // Reset the button visibility and enable it for next submission
                    document.getElementById("ServiceRequestAddButton").disabled = false;
                    document.getElementById('ServiceRequestAddButton').style.display = 'inline-block';  // Shows the button again
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

        // Reject service request ID
        function serviceRequestRejectButton() {
            var SRRejectID = lastClickedLink.split("-")[1];
            var teamleader_remark = document.getElementById("serviceRequestRejectReason").value;

            $.ajax({
                type: 'POST',
                url: "{{ route('serviceRequest.reject') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: SRRejectID,
                    reject_remark: teamleader_remark
                },
                success: function (response) {
                    // Close modal after successfully deleted
                    var element = "#serviceRequestRejectModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully rejected.", "#91C714");

                    // Reload table
                    $('#service_request_table').DataTable().ajax.reload();

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

        // Delete service request ID
        function serviceRequestDeleteButton() {
            var SRDeleteID = lastClickedLink.split("-")[1];

            $.ajax({
                type: 'POST',
                url: "{{ route('serviceRequest.delete') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: SRDeleteID,
                },
                success: function (response) {
                    // Close modal after successfully deleted
                    var element = "#serviceRequestDeleteModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully deleted.", "#91C714");

                    // Reload table
                    $('#service_request_table').DataTable().ajax.reload();

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

    });

</script>
@endsection('script')