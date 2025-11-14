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

<!-- datatable -->
<div class="intro-y box p-5 mt-5">

    <!-- BEGIN: User Status Info -->
    <div class="rounded-md px-5 py-4 mb-2 bg-gray-200 text-gray-600">
        <div class="flex items-center">
            <div class="font-medium text-lg">User Info:</div>
        </div>
        <ul>
            <li> <b> User Status: Active </b> - Users are active and allowed to access the system.</li>
            <li> <b> User Status: Disabled </b> - Users are deleted and not allowed to access the system.</li>
        </ul>
    </div>
    <!-- END: User Status Info -->

    <div class="pos col-span-12 lg:col-span-4">
        <!-- BEGIN: Users -->
        <div class="tab-content__pane mt-4 active">
            <!-- BEGIN: Filter & Add New User -->
            <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                <!-- BEGIN: Filter -->
                <form class="xl:flex sm:mr-auto">
                    <!-- <div class="sm:flex items-center sm:mr-4">
                        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Role</label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputEmployeeRole">
                            <option value="all">All</option>
                            <option value="team_leader">Team Leader</option>
                            <option value="employee_technician">Employee Technician</option>
                        </select>
                    </div>
                    <div class="mt-2 xl:mt-0">
                        <button type="button" class="button w-full sm:w-16 bg-theme-32 text-white" id="filterEmployeeButton">Filter</button>
                    </div> -->
                </form>
                <!-- END: Filter -->

                <!-- BEGIN: Add New User -->
                <div class="text-center">
                    <a href="javascript:;" data-toggle="modal" data-target="#usersAddModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white" id="usersAddModalButton">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Register New User
                    </a>
                </div>
                <!-- END: Add New User -->
            </div>
            <!-- END: Filter & Add New User -->

            <!-- BEGIN: Users List -->
            <div class="overflow-x-auto scrollbar-hidden">
                <table class="table mt-5" id="users_table">
                    <thead>
                        <tr class="bg-theme-32 text-white">
                            <th>No.</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Email</th>
                            <!-- <th>Last Login At</th> -->
                            <th class="dt-no-sort dt-exclude-export">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- END: Users List -->
        </div>
        <!-- END: Users -->
    </div>
</div>
@endsection('app_content')

@section('modal_content')
<!-- BEGIN: Users Edit Modal -->
<div class="modal" id="usersEditModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Edit User</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Name <span style="color: red;">*</span></label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Name" id="usersEditName" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Username <span style="color: red;">*</span></label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="System Login Username" id="usersEditUsername" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Role <span style="color: red;">*</span></label>
                    <select class="input w-full border mt-2 flex-1" id="usersEditRole" required>
                        <option value="superadmin">Superadmin</option>
                        <option value="admin">Admin</option>
                        <option value="supports">Supports</option>
                        <option value="sales">Sales</option>
                        <option value="services">Services</option>
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Email <span style="color: red;">*</span></label>
                    <input type="email" class="input w-full border mt-2 flex-1" placeholder="example@gmail.com" id="usersEditEmail" required>
                </div>
            </div>

            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="usersEditButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Users Edit Modal -->

<!-- BEGIN: Users Add Modal -->
<div class="modal" id="usersAddModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Add User</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Name <span style="color: red;">*</span></label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Name" id="usersAddName" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Username <span style="color: red;">*</span></label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Username" id="usersAddUsername" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Role <span style="color: red;">*</span></label>
                    <select class="input w-full border mt-2 flex-1" id="usersAddRole" required>
                        <option value="superadmin">Superadmin</option>
                        <option value="admin">Admin</option>
                        <option value="support">Support</option>
                        <option value="sales">Sales</option>
                        <option value="services">Services</option>
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Password <span style="color: red;">*</span></label>
                    <input type="password" class="input w-full border mt-2 flex-1" placeholder="Password" id="usersAddPassword" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Password Confirmation <span style="color: red;">*</span></label>
                    <input type="password" class="input w-full border mt-2 flex-1" placeholder="Password" id="usersAddPasswordConfirmation" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Email <span style="color: red;">*</span></label>
                    <input type="email" class="input w-full border mt-2 flex-1" placeholder="example@gmail.com" id="usersAddEmail" required>
                </div>
            </div>

            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="usersAddButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Users Add Modal -->

<!-- BEGIN: Users Delete Modal -->
<div class="modal" id="usersDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm deleting the user? This process cannot be undone.</div>
        </div>
        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="usersDeleteButton">Delete</button>
        </div>
    </div>
</div>
<!-- END: Users Delete Modal -->

@endsection('modal_content')

@section('script')
<script>
    $(document).ready(function() {
        // Global variables
        var original_username;
        var lastClickedLink;

        // Listen to below buttons
        document.getElementById("usersAddButton").addEventListener("click", usersAddButton);
        document.getElementById("usersDeleteButton").addEventListener("click", usersDeleteButton);

        // When any submit button is clicked
        (function() {
            var users_table = $('#users_table')[0].altEditor;

            document.getElementById('usersAddButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();
            });

            document.getElementById('usersEditButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Edit users
                editUsers();
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
         * USERS 
         */

        // Setup the users datatable
        function initUsersDatatable() {
            const dt = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName = `Users_List_${formattedDate}_${formattedTime}`;

            const table = $('#users_table').DataTable({
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
                    url: "{{ route('users.list') }}",
                    dataType: "json",
                    type: "POST",
                    method:"POST",
                    data: function(d) {
                        d._token    = $('meta[name="csrf-token"]').attr('content');
                        
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
                        data: "name",
                    },
                    {
                        data: "username",
                    },
                    {
                        data: "role",
                    },
                    {
                        data: "email",
                    },
                    // {
                    //     data: "last_login_at",
                    // },
                    {
                        data: "id",
                        render: function(data, type, row) {
                            let element = `
                            <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#usersDeleteModal" id="delete-user-` + data + `">
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
            var filterDiv = document.getElementById("users_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv = document.getElementById("users_table_info");
            var paginateDiv = document.getElementById("users_table_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "users_table_length" div and its select element
            var existingDiv = document.getElementById("users_table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }

            // Open modal to edit user
            usersEditModal();
        };

        // Add New User
        function usersAddButton() {
            $.ajax({
                type: 'POST',
                url: "{{ route('users.create') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    name: document.getElementById("usersAddName").value,
                    username: document.getElementById("usersAddUsername").value,
                    role: document.getElementById("usersAddRole").value,
                    password: document.getElementById("usersAddPassword").value,
                    password_confirmation: document.getElementById("usersAddPasswordConfirmation").value,
                    email: document.getElementById("usersAddEmail").value
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#usersAddModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("usersAddName").value = "";
                    document.getElementById("usersAddUsername").value = "";
                    document.getElementById("usersAddRole").value = "";
                    document.getElementById("usersAddPassword").value = "";
                    document.getElementById("usersAddPasswordConfirmation").value = "";
                    document.getElementById("usersAddEmail").value = "";

                    // Reload table
                    $('#users_table').DataTable().ajax.reload();
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

        // Open modal to edit user
        function usersEditModal() {
            // Remove previous click event listeners
            $(document).off('click', "[id^='users_table'] tbody tr td:not(:last-child)");

            $(document).on('click', "[id^='users_table'] tbody tr td:not(:last-child)", function() {
                // Assign original username to global variable
                original_username = $(event.target).closest('tr').find('td:nth-child(' + '3' + ')').text();

                // Place values to edit form fields in the modal
                document.getElementById("usersEditName").value = $(event.target).closest('tr').find('td:nth-child(' + '2' + ')').text();
                document.getElementById("usersEditUsername").value = $(event.target).closest('tr').find('td:nth-child(' + '3' + ')').text();
                document.getElementById("usersEditEmail").value = $(event.target).closest('tr').find('td:nth-child(' + '5' + ')').text();

                var selectRole = $(event.target).closest('tr').find('td:nth-child(' + '4' + ')').text();

                if (selectRole == "superadmin") {
                    document.getElementById("usersEditRole").value = "superadmin";
                } else if (selectRole == "admin") {
                    document.getElementById("usersEditRole").value = "admin";
                } else if (selectRole == "support") {
                    document.getElementById("usersEditRole").value = "support";
                } else if (selectRole == "sales") {
                    document.getElementById("usersEditRole").value = "sales";
                } else if (selectRole == "services") {
                    document.getElementById("usersEditRole").value = "services";
                }

                // Open modal
                var element = "#usersEditModal";
                openAltEditorModal(element);
            });
        }

        // Edit User
        function editUsers() {
            var name = document.getElementById("usersEditName").value;
            var username = document.getElementById("usersEditUsername").value;
            var role = document.getElementById("usersEditRole").value;
            var email = document.getElementById("usersEditEmail").value;

            $.ajax({
                type: 'POST',
                url: "{{ route('users.edit') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    name: name,
                    username: username,
                    original_username: original_username,
                    role: role,
                    email: email
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#usersEditModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully edited.", "#91C714");

                    // Reload table
                    $('#users_table').DataTable().ajax.reload();
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

        // Delete User
        function usersDeleteButton() {
            var delete_user_id = lastClickedLink.split("-")[2];

            $.ajax({
                type: 'POST',
                url: "{{ route('users.delete') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    delete_user_id: delete_user_id
                },
                success: function(response) {
                    // Close modal after successfully deleted
                    var element = "#usersDeleteModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully deleted.", "#91C714");

                    // Reload table
                    $('#users_table').DataTable().ajax.reload();
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

        initUsersDatatable();
        
    })
</script>
@endsection('script')