@extends('layouts.main')

@section('title')
<title>Chulia Middle East - Users</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Users
    </h2>
</div>

<div class="intro-y box p-5 mt-5">

    <!-- BEGIN: User Status Info -->
    <div class="rounded-md px-5 py-4 mb-2 bg-gray-200 text-gray-600">
        <div class="flex items-center">
            <div class="font-medium text-lg">User Status Info:</div>
        </div>
        <ul>
            <li> <b> User Status: Active </b> - Users are active and allowed to access the system.</li>
            <li> <b> User Status: Disabled </b> - Users are deleted and not allowed to access the system.</li>
        </ul>
    </div>
    <!-- END: User Status Info -->

    <div class="pos col-span-12 lg:col-span-4">
        <!-- BEGIN: Tabs -->
        <div class="intro-y pr-1">
            <div class="box p-2">
                <div class="pos__tabs nav-tabs justify-center flex">
                    <a data-toggle="tab" data-target="#employee_users" href="javascript:;" class="flex-1 py-2 rounded-md text-center active">Employee Users</a>
                    <a data-toggle="tab" data-target="#client_users" href="javascript:;" class="flex-1 py-2 rounded-md text-center">Client Users</a>
                </div>
            </div>
        </div>
        <!-- END: Tabs -->

        <div class="tab-content">

            <!-- BEGIN: Employee Users -->
            <div class="tab-content__pane mt-4 active" id="employee_users">
                <!-- BEGIN: Filter & Add New User -->
                <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                    <!-- BEGIN: Filter -->
                    <form class="xl:flex sm:mr-auto">
                        <div class="sm:flex items-center sm:mr-4">
                            <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Role</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputEmployeeRole">
                                <option value="all">All</option>
                                <option value="team_leader">Team Leader</option>
                                <option value="employee_technician">Employee Technician</option>
                            </select>
                        </div>
                        <div class="mt-2 xl:mt-0">
                            <button type="button" class="button w-full sm:w-16 bg-theme-32 text-white" id="filterEmployeeButton">Filter</button>
                        </div>
                    </form>
                    <!-- END: Filter -->

                    <!-- BEGIN: Add New User -->
                    <div class="text-center">
                        <a href="javascript:;" data-toggle="modal" data-target="#employeeUsersAddModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white" id="employeeUsersAddModalButton">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Register New Employee User
                        </a>
                    </div>
                    <!-- END: Add New User -->
                </div>
                <!-- END: Filter & Add New User -->

                <!-- BEGIN: Users List -->
                <div class="overflow-x-auto scrollbar-hidden">
                    <table class="table mt-5" id="employee_users_table">
                        <thead>
                            <tr class="bg-theme-32 text-white">
                                <th>System Display Name</th>
                                <th>System Login Username</th>
                                <th>Employee Name</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th class="text-center">User Status</th>
                                <th>Last Login At</th>
                                <th class="dt-no-sort dt-exclude-export">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <!-- END: Users List -->
            </div>
            <!-- END: Employee Users -->

            <!-- BEGIN: Client Users -->
            <div class="tab-content__pane mt-4" id="client_users">
                <!-- BEGIN: Filter & Add New User -->
                <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                    <!-- BEGIN: Filter -->
                    <form class="xl:flex sm:mr-auto">
                        <div class="sm:flex items-center sm:mr-4">
                            <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Company</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputClientCompany">
                                <option value="all">All</option>
                                @foreach($client_companies as $client_company)
                                <option value="{{ $client_company->id }}">{{ $client_company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sm:flex items-center sm:mr-4">
                            <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Role</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputClientRole">
                                <option value="all">All</option>
                                <option value="client_user">Client User</option>
                            </select>
                        </div>
                        <div class="mt-2 xl:mt-0">
                            <button type="button" class="button w-full sm:w-16 bg-theme-32 text-white" id="filterClientButton">Filter</button>
                        </div>
                    </form>
                    <!-- END: Filter -->

                    <!-- BEGIN: Add New User -->
                    <div class="text-center">
                        <a href="javascript:;" data-toggle="modal" data-target="#clientUsersAddModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white" id="clientUsersAddModalButton">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Register New Client User
                        </a>
                    </div>
                    <!-- END: Add New User -->
                </div>
                <!-- END: Filter & Add New User -->

                <!-- BEGIN: Users List -->
                <div class="overflow-x-auto scrollbar-hidden">
                    <table class="table mt-5" id="client_users_table">
                        <thead>
                            <tr class="bg-theme-32 text-white">
                                <th>System Display Name</th>
                                <th>System Login Username</th>
                                <th>Client Company</th>
                                <th>Client Name</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th class="text-center">User Status</th>
                                <th>Last Login At</th>
                                <th class="dt-no-sort dt-exclude-export">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- END: Users List -->
            </div>
            <!-- END: Client Users -->
        </div>
    </div>
</div>
@endsection('app_content')

@section('modal_content')
<!-- BEGIN: Employee Users Edit Modal -->
<div class="modal" id="employeeUsersEditModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Edit User</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>System Display Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="System Display Name" id="employeeUsersEditName" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>System Login Username</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="System Login Username" id="employeeUsersEditUsername" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Role</label>
                    <select class="input w-full border mt-2 flex-1" id="employeeUsersEditRole" required>
                        <option value="superadmin">Superadmin</option>
                        <option value="employee_occ_admin">OCC Admin</option>
                        <option value="employee_occ_operator">OCC Operator</option>
                        <option value="team_leader">Team Leader</option>
                        <option value="employee_technician">Employee Technician</option>
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Email</label>
                    <input type="email" class="input w-full border mt-2 flex-1" placeholder="example@gmail.com" id="employeeUsersEditEmail" required>
                </div>
            </div>

            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="employeeUsersEditButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Employee Users Edit Modal -->

<!-- BEGIN: Employee Users Add Modal -->
<div class="modal" id="employeeUsersAddModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Add User</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>System Display Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="System Display Name" id="employeeUsersAddName" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>System Login Username</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="System Login Username" id="employeeUsersAddUsername" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Role</label>
                    <select class="input w-full border mt-2 flex-1" id="employeeUsersAddRole" required>
                        <option value="employee_occ_admin">OCC Admin</option>
                        <option value="employee_occ_operator">OCC Operator</option>
                        <option value="team_leader">Team Leader</option>
                        <option value="employee_technician">Employee Technician</option>
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Employee Name</label>
                    <select class="input w-full border mt-2 flex-1" id="employeeUsersAddEmployee" required>
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Password</label>
                    <input type="password" class="input w-full border mt-2 flex-1" placeholder="Password" id="employeeUsersAddPassword" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Password Confirmation</label>
                    <input type="password" class="input w-full border mt-2 flex-1" placeholder="Password" id="employeeUsersAddPasswordConfirmation" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Email</label>
                    <input type="email" class="input w-full border mt-2 flex-1" placeholder="example@gmail.com" id="employeeUsersAddEmail" required>
                </div>
            </div>

            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="employeeUsersAddButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Employee Users Add Modal -->

<!-- BEGIN: Employee Users Delete Modal -->
<div class="modal" id="employeeUsersDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm deleting the user? This process cannot be undone.</div>
        </div>
        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="employeeUsersDeleteButton">Delete</button>
        </div>
    </div>
</div>
<!-- END: Employee Users Delete Modal -->

<!-- BEGIN: Client Users Edit Modal -->
<div class="modal" id="clientUsersEditModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Edit User</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>System Display Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="System Display Name" id="clientUsersEditName" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>System Login Username</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="System Login Username" id="clientUsersEditUsername" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Role</label>
                    <select class="input w-full border mt-2 flex-1" id="clientUsersEditRole" required>
                        <option value="client_user">Client User</option>
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Email</label>
                    <input type="email" class="input w-full border mt-2 flex-1" placeholder="example@gmail.com" id="clientUsersEditEmail" required>
                </div>
            </div>

            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="clientUsersEditButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Client Users Edit Modal -->

<!-- BEGIN: Client Users Add Modal -->
<div class="modal" id="clientUsersAddModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Add User</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>System Display Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="System Display Name" id="clientUsersAddName" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>System Login Username</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="System Login Username" id="clientUsersAddUsername" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Role</label>
                    <select class="input w-full border mt-2 flex-1" id="clientUsersAddRole" required>
                        <option value="client_user">Client User</option>
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Client Company</label>
                    <select class="input w-full border mt-2 flex-1" id="clientUsersAddClientCompany" required>
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Client Name</label>
                    <select class="input w-full border mt-2 flex-1" id="clientUsersAddClient" required>
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Password</label>
                    <input type="password" class="input w-full border mt-2 flex-1" placeholder="Password" id="clientUsersAddPassword" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Password Confirmation</label>
                    <input type="password" class="input w-full border mt-2 flex-1" placeholder="Password" id="clientUsersAddPasswordConfirmation" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Email</label>
                    <input type="email" class="input w-full border mt-2 flex-1" placeholder="example@gmail.com" id="clientUsersAddEmail" required>
                </div>
            </div>

            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="clientUsersAddButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Client Users Add Modal -->

<!-- BEGIN: Client Users Delete Modal -->
<div class="modal" id="clientUsersDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm deleting the user? This process cannot be undone.</div>
        </div>
        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="clientUsersDeleteButton">Delete</button>
        </div>
    </div>
</div>
<!-- END: Client Users Delete Modal -->


@endsection('modal_content')

@section('script')
<script>
    $(document).ready(function() {
        // Global variables
        var original_employee_username;
        var original_client_username;
        var client_type = "default";
        var client_id;
        var lastClickedLink;

        // Listen to below buttons
        document.getElementById("filterEmployeeButton").addEventListener("click", filterEmployeeButton);
        document.getElementById("filterClientButton").addEventListener("click", filterClientButton);
        document.getElementById("employeeUsersAddButton").addEventListener("click", employeeUsersAddButton);
        document.getElementById("employeeUsersAddModalButton").addEventListener("click", employeeUsersAddButtonGetEmployees);
        document.getElementById("employeeUsersDeleteButton").addEventListener("click", employeeUsersDeleteButton);
        document.getElementById("clientUsersAddButton").addEventListener("click", clientUsersAddButton);
        document.getElementById("clientUsersAddModalButton").addEventListener("click", clientUsersAddButtonGetClients);
        document.getElementById("clientUsersDeleteButton").addEventListener("click", clientUsersDeleteButton);

        // When "filterEmployeeButton" button is clicked, initiate initemployeeUsersDatatable
        var filterEmployeeRole;

        function filterEmployeeButton() {
            filterEmployeeRole = document.getElementById("inputEmployeeRole").value;
            initemployeeUsersDatatable(filterEmployeeRole);
        };

        // When "filterClientButton" button is clicked, initiate initClientUsersDatatable
        var filterClientRole;
        var filterClientCompany;

        function filterClientButton() {
            filterClientRole = document.getElementById("inputClientRole").value;
            filterClientCompany = document.getElementById("inputClientCompany").value;
            initClientUsersDatatable(filterClientRole, filterClientCompany);
        };

        // When page first loads, load tables
        filterEmployeeButton();
        filterClientButton();

        // When any submit button is clicked
        (function() {
            var employee_users_table = $('#employee_users_table')[0].altEditor;
            var client_users_table = $('#client_users_table')[0].altEditor;

            document.getElementById('employeeUsersAddButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();
            });

            document.getElementById('employeeUsersEditButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Edit employee users
                editemployeeUsers();
            });

            document.getElementById('clientUsersAddButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();
            });

            document.getElementById('clientUsersEditButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Edit client users
                editClientUsers();
            });
        })();

        // // Store the ID of the last clicked modal when it's triggered
        (function() {
            $(document).on('click', "[data-toggle='modal']", function() {
                lastClickedLink = $(this).attr('id');
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


        /**
         * EMPLOYEE USERS 
         */

        // Setup the Employee users datatable
        function initemployeeUsersDatatable(filterEmployeeRole) {
            const dt = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName = `Employee_Users_List_${formattedDate}_${formattedTime}`;

            const table = $('#employee_users_table').DataTable({
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
                    url: "{{ route('users.list.employee') }}",
                    dataType: "json",
                    type: "POST",
                    data: function(d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        d.role = filterEmployeeRole;
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
                columns: [{
                        data: "name",
                    },
                    {
                        data: "username",
                    },
                    {
                        data: "employee_name",
                    },
                    {
                        data: "role",
                        render: function(data, type, row) {
                            let element = ``

                            if (data == "superadmin") {
                                element = `Superadmin`;
                            } else if (data == "employee_occ_admin") {
                                element = `OCC Admin`;
                            } else if (data == "employee_occ_operator") {
                                element = `OCC Operator`;
                            } else if (data == "team_leader") {
                                element = `Team Leader`;
                            } else if (data == "employee_technician") {
                                element = `Employee Technician`;
                            }

                            return element;
                        }
                    },
                    {
                        data: "email",
                    },
                    {
                        data: "status",
                        render: function(data, type, row) {
                            let element = `<div class="cursor-pointer rounded-full bg-theme-9 px-2 py-1 text-xs font-medium text-center text-white">
                                                Active
                                            </div>`;

                            return element;
                        }
                    },
                    {
                        data: "last_login_at",
                    },
                    {
                        data: "id",
                        render: function(data, type, row) {
                            let element = `
                            <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#employeeUsersDeleteModal" id="delete-employee-` + data + `">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 w-4 h-4 mr-1">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg> 
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
            var filterDiv = document.getElementById("employee_users_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv = document.getElementById("employee_users_table_info");
            var paginateDiv = document.getElementById("employee_users_table_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "employee_users_table_length" div and its select element
            var existingDiv = document.getElementById("employee_users_table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }

            // Open modal to edit employee user
            employeeUsersEditModal();
        };

        // Add New Employee User - Get Employees
        function employeeUsersAddButtonGetEmployees() {
            $.ajax({
                type: 'GET',
                url: "{{ route('users.create.employee.get.employees') }}",
                data: {
                    _token: $('input[name="csrf-token"]').val(),
                },
                success: function(response) {
                    var selectElement = document.getElementById("employeeUsersAddEmployee");
                    selectElement.innerHTML = '';

                    response.employees_list.forEach(function(item) {
                        var option = document.createElement("option");
                        option.text = item.name;
                        option.value = item.id;
                        selectElement.add(option);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        };

        // Add New Employee User
        function employeeUsersAddButton() {
            $.ajax({
                type: 'POST',
                url: "{{ route('users.create.employee') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    name: document.getElementById("employeeUsersAddName").value,
                    username: document.getElementById("employeeUsersAddUsername").value,
                    role: document.getElementById("employeeUsersAddRole").value,
                    employee: document.getElementById("employeeUsersAddEmployee").value,
                    password: document.getElementById("employeeUsersAddPassword").value,
                    password_confirmation: document.getElementById("employeeUsersAddPasswordConfirmation").value,
                    email: document.getElementById("employeeUsersAddEmail").value
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#employeeUsersAddModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("employeeUsersAddName").value = "";
                    document.getElementById("employeeUsersAddUsername").value = "";
                    document.getElementById("employeeUsersAddRole").value = "";
                    document.getElementById("employeeUsersAddEmployee").value = "";
                    document.getElementById("employeeUsersAddPassword").value = "";
                    document.getElementById("employeeUsersAddPasswordConfirmation").value = "";
                    document.getElementById("employeeUsersAddEmail").value = "";

                    // Reload table
                    $('#employee_users_table').DataTable().ajax.reload();
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

        // Open modal to edit employee user
        function employeeUsersEditModal() {
            // Remove previous click event listeners
            $(document).off('click', "[id^='employee_users_table'] tbody tr td:not(:last-child)");

            $(document).on('click', "[id^='employee_users_table'] tbody tr td:not(:last-child)", function() {
                // Assign original username to global variable
                original_employee_username = $(event.target).closest('tr').find('td:nth-child(' + '2' + ')').text();

                // Place values to edit form fields in the modal
                document.getElementById("employeeUsersEditName").value = $(event.target).closest('tr').find('td:nth-child(' + '1' + ')').text();
                document.getElementById("employeeUsersEditUsername").value = $(event.target).closest('tr').find('td:nth-child(' + '2' + ')').text();
                document.getElementById("employeeUsersEditEmail").value = $(event.target).closest('tr').find('td:nth-child(' + '5' + ')').text();

                var selectRole = $(event.target).closest('tr').find('td:nth-child(' + '4' + ')').text();

                if (selectRole == "superadmin") {
                    document.getElementById("employeeUsersEditRole").value = "Superadmin";
                } else if (selectRole == "team_leader") {
                    document.getElementById("employeeUsersEditRole").value = "Team Leader";
                } else if (selectRole == "employee_technician") {
                    document.getElementById("employeeUsersEditRole").value = "Employee Technician";
                }

                // Open modal
                var element = "#employeeUsersEditModal";
                openAltEditorModal(element);
            });
        }

        // Edit Employee User
        function editemployeeUsers() {
            var name = document.getElementById("employeeUsersEditName").value;
            var username = document.getElementById("employeeUsersEditUsername").value;
            var role = document.getElementById("employeeUsersEditRole").value;
            var email = document.getElementById("employeeUsersEditEmail").value;

            $.ajax({
                type: 'POST',
                url: "{{ route('users.edit.employee') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    name: name,
                    username: username,
                    original_username: original_employee_username,
                    role: role,
                    email: email
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#employeeUsersEditModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully edited.", "#91C714");

                    // Reload table
                    $('#employee_users_table').DataTable().ajax.reload();
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

        // Delete Employee User
        function employeeUsersDeleteButton() {
            var delete_user_id = lastClickedLink.split("-")[2];

            $.ajax({
                type: 'POST',
                url: "{{ route('users.delete.employee') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    delete_user_id: delete_user_id
                },
                success: function(response) {
                    // Close modal after successfully deleted
                    var element = "#employeeUsersDeleteModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully deleted.", "#91C714");

                    // Reload table
                    $('#employee_users_table').DataTable().ajax.reload();
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

        /**
         * CLIENT USERS 
         */

        // Setup the client users datatable
        function initClientUsersDatatable(filterClientRole, filterClientCompany) {
            const dt = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName = `Client_Users_List_${formattedDate}_${formattedTime}`;

            const table = $('#client_users_table').DataTable({
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
                    url: "{{ route('users.list.client') }}",
                    dataType: "json",
                    type: "POST",
                    data: function(d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        d.role = filterClientRole;
                        d.company = filterClientCompany;
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
                columns: [{
                        data: "name",
                    },
                    {
                        data: "username",
                    },
                    {
                        data: "client_company",
                    },
                    {
                        data: "client_name",
                    },
                    {
                        data: "role",
                        type: "readonly",
                        render: function(data, type, row) {
                            let element = ``

                            if (data == "client_user") {
                                element = `Client User`;
                            }

                            return element;
                        }
                    },
                    {
                        data: "email",
                    },
                    {
                        data: "status",
                        type: "readonly",
                        render: function(data, type, row) {
                            let element = `<div class="cursor-pointer rounded-full bg-theme-9 px-2 py-1 text-xs font-medium text-center text-white">
                                                Active
                                            </div>`;

                            return element;
                        }
                    },
                    {
                        data: "last_login_at",
                    },
                    {
                        data: "id",
                        render: function(data, type, row) {
                            let element = `
                            <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#clientUsersDeleteModal" id="delete-client-` + data + `">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 w-4 h-4 mr-1">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg> 
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
            var filterDiv = document.getElementById("client_users_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv = document.getElementById("client_users_table_info");
            var paginateDiv = document.getElementById("client_users_table_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "client_users_table_length" div and its select element
            var existingDiv = document.getElementById("client_users_table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }

            // Open modal to edit client user
            clientUsersEditModal();
        };

        // Add New Client User - Get Clients
        function clientUsersAddButtonGetClients() {
            var selectElementClientCompany = document.getElementById("clientUsersAddClientCompany");
            var selectElementClient = document.getElementById("clientUsersAddClient");
            selectElementClientCompany.innerHTML = '';
            selectElementClient.innerHTML = '';

            $.ajax({
                type: 'GET',
                url: "{{ route('users.create.client.get.clients') }}",
                data: {
                    _token: $('input[name="csrf-token"]').val(),
                    type: client_type,
                    client_id: client_id,
                },
                success: function(response) {
                    response.client_company_list.forEach(function(item) {
                        var option = document.createElement("option");
                        option.text = item.name;
                        option.value = item.id;
                        selectElementClientCompany.add(option);
                    });

                    document.getElementById("clientUsersAddClientCompany").value = client_id;

                    response.clients_list.forEach(function(item) {
                        var option = document.createElement("option");
                        option.text = item.name;
                        option.value = item.id;
                        selectElementClient.add(option);
                    });

                    document.getElementById("clientUsersAddClient").value = "";

                    function changeEventHandler() {
                        var selectedOption = selectElementClientCompany.options[selectElementClientCompany.selectedIndex];
                        client_type = "non_default";
                        client_id = document.getElementById("clientUsersAddClientCompany").value;
                        clientUsersAddButtonGetClients();
                    }

                    // Check if there is an existing event listener and remove it
                    if (window.previousChangeEventHandler) {
                        selectElementClientCompany.removeEventListener('change', window.previousChangeEventHandler);
                    }

                    // Set the new event listener and store it in the global variable
                    selectElementClientCompany.addEventListener('change', changeEventHandler);
                    window.previousChangeEventHandler = changeEventHandler;
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        };

        // Add New Client User
        function clientUsersAddButton() {
            $.ajax({
                type: 'POST',
                url: "{{ route('users.create.client') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    name: document.getElementById("clientUsersAddName").value,
                    username: document.getElementById("clientUsersAddUsername").value,
                    role: document.getElementById("clientUsersAddRole").value,
                    client: document.getElementById("clientUsersAddClient").value,
                    password: document.getElementById("clientUsersAddPassword").value,
                    password_confirmation: document.getElementById("clientUsersAddPasswordConfirmation").value,
                    email: document.getElementById("clientUsersAddEmail").value
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#clientUsersAddModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("clientUsersAddName").value = "";
                    document.getElementById("clientUsersAddUsername").value = "";
                    document.getElementById("clientUsersAddRole").value = "";
                    document.getElementById("clientUsersAddClient").value = "";
                    document.getElementById("clientUsersAddClientCompany").value = "";
                    document.getElementById("clientUsersAddPassword").value = "";
                    document.getElementById("clientUsersAddPasswordConfirmation").value = "";
                    document.getElementById("clientUsersAddEmail").value = "";

                    // Reload table
                    $('#client_users_table').DataTable().ajax.reload();
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

        // Open modal to edit client user
        function clientUsersEditModal() {
            // Remove previous click event listeners
            $(document).off('click', "[id^='client_users_table'] tbody tr td:not(:last-child)");

            $(document).on('click', "[id^='client_users_table'] tbody tr td:not(:last-child)", function(event) {
                // Assign original username to global variable
                original_client_username = $(event.target).closest('tr').find('td:nth-child(' + '2' + ')').text();

                // Place values to edit form fields in the modal
                document.getElementById("clientUsersEditName").value = $(event.target).closest('tr').find('td:nth-child(' + '1' + ')').text();
                document.getElementById("clientUsersEditUsername").value = $(event.target).closest('tr').find('td:nth-child(' + '2' + ')').text();
                document.getElementById("clientUsersEditEmail").value = $(event.target).closest('tr').find('td:nth-child(' + '6' + ')').text();

                var selectRole = $(event.target).closest('tr').find('td:nth-child(' + '5' + ')').text();

                if (selectRole == "client_user") {
                    document.getElementById("clientUsersEditRole").value = "Client User";
                }

                // Open modal
                var element = "#clientUsersEditModal";
                openAltEditorModal(element);
            });
        }

        // Edit Client User
        function editClientUsers() {
            var name = document.getElementById("clientUsersEditName").value;
            var username = document.getElementById("clientUsersEditUsername").value;
            var role = document.getElementById("clientUsersEditRole").value;
            var email = document.getElementById("clientUsersEditEmail").value;

            $.ajax({
                type: 'POST',
                url: "{{ route('users.edit.client') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    name: name,
                    username: username,
                    original_username: original_client_username,
                    role: role,
                    email: email
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#clientUsersEditModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully edited.", "#91C714");

                    // Reload table
                    $('#client_users_table').DataTable().ajax.reload();
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

        // Delete Client User
        function clientUsersDeleteButton() {
            var delete_user_id = lastClickedLink.split("-")[2];

            $.ajax({
                type: 'POST',
                url: "{{ route('users.delete.client') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    delete_user_id: delete_user_id
                },
                success: function(response) {
                    // Close modal after successfully deleted
                    var element = "#clientUsersDeleteModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully deleted.", "#91C714");

                    // Reload table
                    $('#client_users_table').DataTable().ajax.reload();
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
    })
</script>
@endsection('script')