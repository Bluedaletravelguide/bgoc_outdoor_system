@extends('layouts.main')

@section('title')
<title>Chulia Middle East - Employees</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Employees
    </h2>
</div>
<div class="intro-y box p-5 mt-5">
    <div class="mb-5 p-5 rounded-md" style="background-color:#ECF9FD;">
        <h2 class="text-lg font-medium">
            Employee Status info
        </h2>
        <p class="w-12 flex-none xl:w-auto xl:flex-initial ml-2">
            <i class="font-bold">User Account Registered</i> - Employee have user registered.
        </p>
        <P class="w-12 flex-none xl:w-auto xl:flex-initial ml-2">
            <i class="font-bold">No User Account Registered</i> - No user is registered to Employee.
        </P>
    </div>
    <!-- Create Modal -->
    <div class="modal" id="basic-modal-create"> 
        <div class="modal__content"> 
            <h2 class="font-medium text-base mr-auto p-2">
                Create New Employee
            </h2>
            <!-- BEGIN: Form Layout Create -->
            <div class="intro-y box p-2">
                <form action="{{ route('employees.create') }}" method="POST">
                @csrf
                    <label>Employee Name</label>
                        <div class="form-group">
                            <input type="text" id="name" name="name" class="input w-full border mt-2" placeholder="Input text">
                        </div>
                        <div class="mt-3 form-group">
                            <label>Contact</label>
                            <div class="relative mt-2">
                                <input type="text" id="contact" name="contact" class="input pr-12 w-full border col-span-4" placeholder="0123456789">
                            </div>
                        </div>
                        <div class="mt-3 form-group">
                            <label>Position</label>
                            <div class="relative mt-2">
                                <input type="text" id="position" name="position" class="input pr-16 w-full border col-span-4" placeholder="Employee Position">
                            </div>
                        </div>
                    <div class="text-right mt-5 p-4">
                        <button type="button" data-dismiss="modal" class="button w-24 border dark:border-dark-5 text-gray-700 dark:text-gray-300 mr-1">Cancel</button>
                        <button type="submit" class="button w-24 bg-theme-1 text-white">Save</button>
                    </div>
                </form>
            </div>
            <!-- END: Form Layout -->
        </div> 
    </div> 
    <!-- Modal End -->
    <!-- Table Filter -->
    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start mb-2 mt-2">
        <form class="xl:flex sm:mr-auto" id="employee_table">
            <div class="row sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Role</label>
                    <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 border" id="inputEmployeeRole">
                        <option value="">All</option>
                        <!-- @foreach ($Users as $User)
                            <option value="{{$User->username}}">{{ $User->name }}</option>
                        @endforeach -->
                        <option value="superadmin">Superadmin</option>
                        <option value="Employee_OCC_Admin">OCC Admin</option>
                        <option value="Employee_OCC_Operator">OCC Operator</option>
                        <option value="Employee_Supervisor">In-House Supervisor</option>
                        <option value="Employee_Technician">In-House Technician</option>
                    </select>
            </div>
            <div class="row sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Employee<br>Status</label>
                <select class="input w-full mt-2 sm:mt-0 sm:w-auto border" id="inputEmployeeStatus">
                    <option value="" selected="">All</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div class="mt-2 xl:mt-0">
                <button type="button" class="button w-full sm:w-16 bg-theme-1 text-white" id="filterEmployeeButton">Filter</button>
            </div>
        </form>
        <div class="text-center">
            <a href="javascript:;" data-toggle="modal" data-target="#basic-modal-create" class="button inline-block bg-theme-1 text-white">
                +Add New Employee
            </a> 
        </div>
    </div>
    <!-- Filter End -->
    <!-- Employee table -->
    <div class="overflow-x-auto scrollbar-hidden">
        <table class="table mt-5" id="employees_table">
            <thead>
                <tr class="bg-theme-1 text-white">
                    <th class="whitespace-nowrap" width="10%">Name</th>
                    <th class="whitespace-nowrap" width="15%">User ID</th>
                    <th class="whitespace-nowrap" width="15%">Contact</th> 
                    <th class="whitespace-nowrap" width="15%">Position</th>
                    <th class="whitespace-nowrap" width="15%">User Account Status</th>
                    <th class="whitespace-nowrap" width="10%">Employee Status</th>
                    <th class="whitespace-nowrap" width="20%">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <!-- Table End -->
    @foreach ($Employees as $Employees)
        <form id="delete-form-{{ $Employees->id }}" action="{{ route('employees.destroy',$Employees->id) }}" method="POST">
            @method('DELETE')
            @csrf
            <div class="form-group">
                <input type="hidden" id="status" name="status" value="{{$Employees->status}}">
                <input type="hidden" id="user" name="user" value="{{$Employees->user_id}}">
            </div>
            <!-- Delete Modal -->
            <div class="modal" id="DeleteModal-{{ $Employees->id }}">
                <div class="modal__content">
                    <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-gray-600 mt-2">Confirm deleting employee?</div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
                        <button class="button w-24 mr-2 mb-2 items-center justify-center bg-theme-6 text-white"
                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $Employees->id }}').submit();"> 
                                Delete 
                        </button> 
                    </div>
                </div>
            </div>
            <!-- END Delete Modal -->
        </form>
        <!-- Edit Modal -->
        <a href="javascript:;" data-toggle="modal" data-target="#basic-modal-edit-{{ $Employees->id }}"
            class="hidden w-24 mr-2 mb-2 bg-theme-12 text-white">
            Edit
        </a> 
        <div class="modal rounded-sm" id="basic-modal-edit-{{ $Employees->id }}"> 
            <div class="modal__content p-2"> 
                <h2 class="text-lg font-medium p-2">
                    Edit Employee Details
                </h2>
                <!-- BEGIN: Form Layout Edit -->
                <div class="intro-y box p-2">
                    <form id="update-form-{{ $Employees->id }}" action="{{ route('employees.edit',$Employees->id) }}" method="POST">
                    @csrf
                        <label>Employee Name</label>
                            <div class="form-group">
                                <input type="hidden" id="status" name="status" value="{{$Employees->status}}">
                            </div>
                            <div class="form-group">
                                <input type="text" id="name" name="name" class="input w-full border mt-2" placeholder="Input text" value="{{ $Employees->name }}">
                            </div>
                            <div class="mt-3 form-group">
                                <label>User ID</label>
                                <div class="mt-2">
                                    <select data-placeholder="Select User ID" id="user_id" name="user_id" class="tail-select w-full">
                                        <option value="">-- Select User --</option>
                                        @foreach ($Users as $User)
                                            <option value="{{$User->id}}" {{ $User->id == $Employees->user_id ? 'selected':'' }}>{{ $User->username }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mt-3 form-group">
                                <label>Contact</label>
                                <div class="relative mt-2">
                                    <input type="text" id="contact" name="contact" class="input pr-12 w-full border col-span-4" value="{{ $Employees->contact }}" placeholder="0123456789">
                                </div>
                            </div>
                            <div class="mt-3 form-group">
                                <label>Position</label>
                                <div class="relative mt-2">
                                    <input type="text" id="position" name="position" class="input pr-16 w-full border col-span-4" value="{{ $Employees->position }}" placeholder="Employee Position">
                                </div>
                            </div>
                        <div class="text-right mt-5 p-4">
                            <button type="button" data-dismiss="modal" class="button w-24 border dark:border-dark-5 text-gray-700 dark:text-gray-300 mr-1">Cancel</button>
                            <button type="submit" class="button w-24 bg-theme-1 text-white">Save</button>
                        </div>
                    </form>
                </div>
                <!-- END: Form Layout -->
            </div> 
        </div> 
        <!-- Modal End -->
    @endforeach
</div>
@endsection('app_content')

@section('modal_content')
<!-- BEGIN: Employees Delete Modal -->
<div class="modal" id="serviceRequestDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm delete this employees? This process cannot be undone.</div>
        </div>

        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="serviceRequestDeleteButton" onclick="serviceRequestDeleteButton()">Delete</button>
        </div>
    </div>
</div>
<!-- END: Employees Reject Modal -->

<!-- BEGIN: SR Edit Modal -->
<div class="modal" id="employeesEditModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Edit Employees</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Name" id="employeesEditName" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Contact No.</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Contact No." id="employeesEditContactNo" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Position</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Position" id="employeesEditPosition" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Status</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Status" id="employeesEditStatus" required>
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
        // Listen to below buttons
        document.getElementById("filterEmployeeButton").addEventListener("click", filterEmployeeButton);

        // When "filterEmployeeButton" button is clicked, initiate initEmployeeDatatable
        var filterEmployeeRole;
        var filterEmployeeStatus;

        function filterEmployeeButton() {
            filterEmployeeRole = document.getElementById("inputEmployeeRole").value;
            filterEmployeeStatus = document.getElementById("inputEmployeeStatus").value;
            initEmployeeDatatable(filterEmployeeRole,filterEmployeeStatus);
        };

        // When page first loads, load the in-house users table
        filterEmployeeButton();

        // Edit Employees
        function editEmployees() {
            var employeeName = document.getElementById("employeesEditName").value;
            var employeeContactNo = document.getElementById("employeesEditContactNo").value;
            var employeePosition = document.getElementById("employeesEditPosition").value;
            var employeeStatus = document.getElementById("employeesEditStatus").value;

            $.ajax({
                type: 'POST',
                url: "{{ route('employees.edit') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    employeeName: employeeName,
                    employeeContactNo: employeeContactNo,
                    employeePosition: employeePosition,
                    employeeStatus: employeeStatus,
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
        function initEmployeeDatatable(filterEmployeeRole,filterEmployeeStatus) {
            const dt = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName = `Employee_List_${formattedDate}_${formattedTime}`;

            const table = $('#employees_table').DataTable({
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
                    url: "{{ route('employees.list') }}",
                    dataType: "json",
                    type: "POST",
                    data: function(d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        d.role = filterEmployeeRole;
                        d.status = filterEmployeeStatus;
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
                        data: "name",
                    },
                    {
                        data: "username",
                    },
                    {
                        data: "contact",
                    },
                    {
                        data: "position",
                    },
                    {
                        data: "user",
                        type: "readonly",
                        render: function(data, type, row) {
                            let element = ``
                            if (data == null) {
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 border text-gray-700 dark:border-dark-5 dark:text-gray-300">No Account Registered</a>`;
                            }else{
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-18 text-black">Account Registered</a>`;
                            }
                            return element;
                        }
                    },
                    {
                        data: "status",
                        type: "readonly",
                        render: function(data, type, row) {
                            let element = ``
                            if (data == '0') {
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 border text-gray-700 dark:border-dark-5 dark:text-gray-300">Inactive</a>`;
                            }else{
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-18 text-black">Active</a>`;
                            }
                            return element;
                        }
                    },
                    {
                        // data: "action",
                        // render: function(data, type, row) {
                        //     let element = `<div class="flex flex-row">
                        //     <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#DeleteModal-` + data + ` id="delete-` + data + `"">
                        //         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 w-4 h-4 mr-1">
                        //             <polyline points="3 6 5 6 21 6"></polyline>
                        //             <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        //             <line x1="10" y1="11" x2="10" y2="17"></line>
                        //             <line x1="14" y1="11" x2="14" y2="17"></line>
                        //         </svg> 
                        //     </a>
                        //     </div>`;
                        //     return element;
                        // }

                        data: "action",
                        render: function(data, type, row) {
                            
                            // Show "Reject" button if the user is superadmin or teamleader
                            let element = `<a href="javascript:;" data-toggle="modal" data-target="#employeesDeleteModal" 
                                        id="delete-` + data + `"
                                        class="button w-24 inline-block mr-2 mb-2 bg-theme-6 text-white">
                                        Delete
                                        </a>`;

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
            var filterDiv = document.getElementById("employee_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv = document.getElementById("employee_table_info");
            var paginateDiv = document.getElementById("employee_table_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "employee_table_length" div and its select element
            var existingDiv = document.getElementById("employee_table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }

            // Open modal to edit Employees
            employeesEditModal();
        };

        // Open modal to edit Employees
        function employeesEditModal() {
            // Remove previous click event listeners
            $(document).off('click', "[id^='employees_table'] tbody tr td:not(:last-child)");

            $(document).on('click', "[id^='employees_table'] tbody tr td:not(:last-child)", function() {

                // Grab row client company id
                originalEmployeesId = $(event.target).closest('tr').find('td:nth-last-child(1) a').attr('id').split('-')[1];

                console.log(originalEmployeesId);

                // Place values to edit form fields in the modal
                document.getElementById("serviceRequestEditDescription").value = $(event.target).closest('tr').find('td:nth-child(' + '3' + ')').text();
                document.getElementById("serviceRequestEditClientRemark").value = $(event.target).closest('tr').find('td:nth-child(' + '4' + ')').text();

                // Open modal
                var element = "#employeesEditModal";
                openAltEditorModal(element);
            });
        }

        var table = $('#table').DataTable({
            "dom": 'rtip',
            "paging":   false,
            "ordering": false,
            "info":     false
        });

    })
</script>
@endsection('script')