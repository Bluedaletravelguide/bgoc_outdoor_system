@extends('layouts.main')

@section('title')
<title>Chulia Middle East - Vendor</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Vendor
    </h2>
</div>

<div class="intro-y box p-5 mt-5">
    <div class="pos col-span-12 lg:col-span-4">
        <!-- BEGIN: Vendor -->
        <div>
            <!-- BEGIN: Filter & Add Vendor -->
            <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                <!-- BEGIN: Filter -->
                <form class="xl:flex sm:mr-auto">
                    <div class="sm:flex items-center sm:mr-4">
                        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">User Account Status</label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputUserAccountStatus">
                            <option value="all">All</option>
                            <option value="1">Account Registered</option>
                            <option value="0">No Account Registered</option>
                        </select>
                    </div>
                    <div class="sm:flex items-center sm:mr-4">
                        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Vendor <br> Company</label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputVendorCompany">
                            <option selected value>All</option>
                            @foreach ($vendorcompany as $vcomp)
                            <option value="{{ $vcomp->id }}">{{ $vcomp->name }}</option>
                            @endforeach
                        </select>
                </div>
                    <div class="mt-2 xl:mt-0">
                        <button type="button" class="button w-full sm:w-16 bg-theme-32 text-white" id="filterVendorButton">Filter</button>
                    </div>
                </form>
                <!-- END: Filter -->

                <!-- BEGIN: Add Vendor -->
                <div class="text-center">
                    <a href="javascript:;" data-toggle="modal" data-target="#VendorsAddModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add New Vendor
                    </a>
                </div>
                <!-- END: Add Vendor -->
            </div>
            <!-- END: Filter & Add Vendor -->

            <!-- BEGIN: Vendor List -->
            <div class="overflow-x-auto scrollbar-hidden">
                <table class="table table-report mt-5" id="vendors_table">
                    <thead>
                        <tr class="bg-theme-32 text-white">
                            <th>Vendor Name</th>
                            <th>Contact No.</th>
                            <th>Vendor Company</th>
                            <th class="text-center dt-no-sort">User Account Status</th>
                            <th class="text-center dt-no-sort">Vendor Status</th>
                            <th class="dt-exclude-export dt-no-sort ">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- END: Vendor List -->
        </div>
        <!-- END: Vendor -->
    </div>
</div>
@endsection('app_content')

@section('modal_content')
<!-- BEGIN: Vendor Add Modal -->
<div class="modal" id="VendorsAddModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Add Vendor</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Vendor Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Vendor Name" id="VendorsAddName" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Contact No.</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Contact No." id="VendorsAddContact" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Vendor Company</label>
                    <select class="input w-full border mt-2 flex-1" id="VendorsAddCompany" required>
                        <option selected disabled value>Select an option</option>
                        @foreach ($vendorcompany as $vcomp)
                        <option value="{{ $vcomp->id }}">{{ $vcomp->name }}</option>
                        @endforeach
                    </select>
                </div>
            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="VendorsAddButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Vendor Add Modal -->

<!-- BEGIN: Vendor Edit Modal -->
<div class="modal" id="VendorsEditModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Edit Vendor</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Vendor Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Vendor Name" id="VendorsEditName" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Contact No.</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Contact No." id="VendorsEditContact" required>
                </div>
            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="VendorsEditButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Vendor Edit Modal -->

<!-- BEGIN: Vendor Delete Modal -->
<div class="modal" id="VendorsDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm deleting the vendor? This process cannot be undone.</div>
        </div>
        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="VendorsDeleteButton">Delete</button>
        </div>
    </div>
</div>
<!-- END: Vendor Delete Modal -->
@endsection('modal_content')

@section('script')
<script>
    $(document).ready(function() {
        // Global variables
        var filterUserAccountStatus;
        var filterVendorCompany;
        var originalVendorsId;
        var lastClickedLink;

        // Listen to below buttons
        document.getElementById("filterVendorButton").addEventListener("click", filterVendorButton);
        document.getElementById("VendorsAddButton").addEventListener("click", VendorsAddButton);
        document.getElementById("VendorsDeleteButton").addEventListener("click", VendorsDeleteButton);

        // When "filterVendorButton" button is clicked, initiate initVendorsDatatable
        function filterVendorButton() {
            filterUserAccountStatus = document.getElementById("inputUserAccountStatus").value;
            filterVendorCompany = document.getElementById("inputVendorCompany").value;
            initVendorsDatatable(filterUserAccountStatus, filterVendorCompany);
        };

        // When page first loads, load table
        filterVendorButton();

        // When any submit button is clicked
        (function() {
            var vendors_table = $('#vendors_table')[0].altEditor;

            document.getElementById('VendorsAddButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();
            });

            document.getElementById('VendorsEditButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Edit Vendor
                editVendors();
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

        // Setup the Vendor datatable
        function initVendorsDatatable() {
            const dt = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName = `Vendors_List_${formattedDate}_${formattedTime}`;

            const table = $('#vendors_table').DataTable({
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
                    url: "{{ route('vendors.list') }}",
                    dataType: "json",
                    type: "POST",
                    data: function(d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        d.ustatus = filterUserAccountStatus;
                        d.vcompany = filterVendorCompany;
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
                        data: "contact",
                    },
                    {
                        data: "company_name",
                    },
                    {
                        data: "ustatus",
                        render: function(data, type, row) {
                            var element;

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
                        render: function(data, type, row) {
                            var element;

                            if (data == "1") {
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-18 text-black">Active</a>`;
                            } else {
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 border text-gray-700 dark:border-dark-5 dark:text-gray-300">Inactive</a>`;
                            }

                            return element;
                        }
                    },
                    {
                        data: "id",
                        render: function(data, type, row) {
                            let element = `
                            <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#VendorsDeleteModal" id="delete-` + data + `">
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
            var filterDiv = document.getElementById("vendors_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv = document.getElementById("vendors_table_info");
            var paginateDiv = document.getElementById("vendors_table_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "vendors_table_length" div and its select element
            var existingDiv = document.getElementById("vendors_table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }

            // Open modal to edit vendor
            VendorsEditModal();
        };

        // Add New Vendor
        function VendorsAddButton() {
            $.ajax({
                type: 'POST',
                url: "{{ route('vendors.create') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    name: document.getElementById("VendorsAddName").value,
                    contact: document.getElementById("VendorsAddContact").value,
                    company: document.getElementById("VendorsAddCompany").value,
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#VendorsAddModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("VendorsAddName").value = "";
                    document.getElementById("VendorsAddContact").value = "";
                    document.getElementById("VendorsAddCompany").value = "";

                    // Reload table
                    $('#vendors_table').DataTable().ajax.reload();
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

        // Open modal to edit vendor
        function VendorsEditModal() {
            // Remove previous click event listeners
            $(document).off('click', "[id^='vendors_table'] tbody tr td:not(:last-child)");

            $(document).on('click', "[id^='vendors_table'] tbody tr td:not(:last-child)", function() {
                // Place values to edit form fields in the modal
                document.getElementById("VendorsEditName").value = $(event.target).closest('tr').find('td:nth-child(' + '1' + ')').text();
                document.getElementById("VendorsEditContact").value = $(event.target).closest('tr').find('td:nth-child(' + '2' + ')').text();

                // Grab row vendor id
                originalVendorsId = $(event.target).closest('tr').find('td:nth-child(6) a').attr('id').split('-')[1];

                // Open modal
                var element = "#VendorsEditModal";
                openAltEditorModal(element);
            });
        }

        // Edit Vendor
        function editVendors() {
            var name = document.getElementById("VendorsEditName").value;
            var contact = document.getElementById("VendorsEditContact").value;

            $.ajax({
                type: 'POST',
                url: "{{ route('vendors.edit') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    name: name,
                    contact: contact,
                    original_vendor_id: originalVendorsId
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#VendorsEditModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("VendorsEditName").value = "";
                    document.getElementById("VendorsEditContact").value = "";

                    // Reload table
                    $('#vendors_table').DataTable().ajax.reload();
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

        // Store the ID of the last clicked moda when it's triggered
        (function() {
            $(document).on('click', "[data-toggle='modal']", function() {
                lastClickedLink = $(this).attr('id');
            });
        })();

        // Delete Vendor
        function VendorsDeleteButton() {
            var deleteVendorId = lastClickedLink.split("-")[1];

            $.ajax({
                type: 'POST',
                url: "{{ route('vendors.delete') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    delete_vendor_id: deleteVendorId
                },
                success: function (response) {
                    // Close modal after successfully deleted
                    var element = "#VendorsDeleteModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully deleted.", "#91C714");

                    // Reload table
                    $('#vendors_table').DataTable().ajax.reload();
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
    })
</script>
@endsection('script')