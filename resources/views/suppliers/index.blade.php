@extends('layouts.main')

@section('title')
<title>Chulia Middle East - Supplier</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Supplier
    </h2>
</div>

<div class="intro-y box p-5 mt-5">
    <div class="pos col-span-12 lg:col-span-4">
        <!-- BEGIN: Supplier -->
        <div>
            <!-- BEGIN: Filter & Add Supplier -->
            <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                <!-- BEGIN: Filter -->
                <form class="xl:flex sm:mr-auto">
                    <div class="sm:flex items-center sm:mr-4">
                        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Supplier <br> Name</label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputSupplierName">
                            <option selected value>All</option>
                            @foreach ($suppliername as $sname)
                            <option value="{{ $sname->id }}">{{ $sname->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-2 xl:mt-0">
                        <button type="button" class="button w-full sm:w-16 bg-theme-32 text-white" id="filterSupplierButton">Filter</button>
                    </div>
                </form>
                <!-- END: Filter -->

                <!-- BEGIN: Add Supplier -->
                <div class="text-center">
                    <a href="javascript:;" data-toggle="modal" data-target="#SuppliersAddModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add New Supplier
                    </a>
                </div>
                <!-- END: Add Supplier -->
            </div>
            <!-- END: Filter & Add Supplier -->

            <!-- BEGIN: Supplier List -->
            <div class="overflow-x-auto scrollbar-hidden">
                <table class="table table-report mt-5" id="suppliers_table">
                    <thead>
                        <tr class="bg-theme-32 text-white">
                            <th>Supplier Code</th>
                            <th>Supplier Name</th>
                            <th>Address</th>
                            <th>Contact Person</th>
                            <th>Phone</th>
                            <th>Fax</th>
                            <th>Email</th>
                            <th>Description</th>
                            <th class="dt-exclude-export dt-no-sort ">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- END: Supplier List -->
        </div>
        <!-- END: Supplier -->
    </div>
</div>
@endsection('app_content')

@section('modal_content')
<!-- BEGIN: Supplier Add Modal -->
<div class="modal" id="SuppliersAddModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Add Supplier</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Supplier Code</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Supplier Code" id="SuppliersAddCode" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Supplier Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Contact No." id="SuppliersAddName" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Address</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Address" id="SuppliersAddAddress" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Contact Person</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Contact Person" id="SuppliersAddContactPerson" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Phone</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Phone" id="SuppliersAddPhone" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Fax (Optional)</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Fax" id="SuppliersAddFax" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Email</label>
                    <input type="email" class="input w-full border mt-2 flex-1" placeholder="example@email.com" id="SuppliersAddEmail" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Decription (Optional)</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Decription" id="SuppliersAddDecription" required>
                </div>
            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="SuppliersAddButton">Submit</button>
            </div>
        </form>
    </div>
</div> -->
<!-- END: Supplier Add Modal -->

<!-- BEGIN: Supplier Edit Modal -->
<div class="modal" id="SuppliersEditModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Edit Supplier</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Supplier Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Supplier Name" id="SuppliersEditName" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Address</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Contact No." id="SuppliersEditAddress" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Contact Person</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Contact Person" id="SuppliersEditContactPerson" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Phone</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Phone" id="SuppliersEditPhone" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Fax (Optional)</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Fax" id="SuppliersEditFax" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Email</label>
                    <input type="email" class="input w-full border mt-2 flex-1" placeholder="example@email.com" id="SuppliersEditEmail" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Decription (Optional)</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Decription" id="SuppliersEditDecription" required>
                </div>
            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="SuppliersEditButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Supplier Edit Modal -->

<!-- BEGIN: Supplier Delete Modal -->
<div class="modal" id="SuppliersDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm deleting the Supplier? This process cannot be undone.</div>
        </div>
        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="SuppliersDeleteButton">Delete</button>
        </div>
    </div>
</div>
<!-- END: Supplier Delete Modal -->
@endsection('modal_content')

@section('script')
<script>
    $(document).ready(function() {
        // Global variables
        var filterUserAccountStatus;
        var filterSupplierName;
        var originalSuppliersId;
        var lastClickedLink;

        // Listen to below buttons
        document.getElementById("filterSupplierButton").addEventListener("click", filterSupplierButton);
        document.getElementById("SuppliersAddButton").addEventListener("click", SuppliersAddButton);
        document.getElementById("SuppliersDeleteButton").addEventListener("click", SuppliersDeleteButton);

        // When "filterSupplierButton" button is clicked, initiate initSuppliersDatatable
        function filterSupplierButton() {
            // filterUserAccountStatus = document.getElementById("inputUserAccountStatus").value;
            filterSupplierName = document.getElementById("inputSupplierName").value;
            initSuppliersDatatable(filterUserAccountStatus, filterSupplierName);
        };

        // When page first loads, load table
        filterSupplierButton();

        // When any submit button is clicked
        (function() {
            var suppliers_table = $('#suppliers_table')[0].altEditor;

            document.getElementById('SuppliersAddButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();
            });

            document.getElementById('SuppliersEditButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Edit Supplier
                editSuppliers();
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

        // Setup the Supplier datatable
        function initSuppliersDatatable() {
            const dt = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName = `Suppliers_List_${formattedDate}_${formattedTime}`;

            const table = $('#suppliers_table').DataTable({
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
                    url: "{{ route('suppliers.list') }}",
                    dataType: "json",
                    type: "POST",
                    data: function(d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        d.suppliername = filterSupplierName;
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
                        data: "code",
                        render: function(data, type, row) {
                            let element = `
                            <a class="flex items-center " id="${row.id}">`+ data +`</a>`;

                            return element;
                        }
                    },
                    {
                        data: "name",
                    },
                    {
                        data: "address",
                    },
                    {
                        data: "contact_person",
                    },
                    {
                        data: "phone",
                    },
                    {
                        data: "fax",
                    },
                    {
                        data: "email",
                    },
                    {
                        data: "description",
                    },
                    {
                        data: "id",
                        render: function(data, type, row) {
                            let element = `
                            <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#SuppliersDeleteModal" id="delete-` + data + `">
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
            var filterDiv = document.getElementById("suppliers_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv = document.getElementById("suppliers_table_info");
            var paginateDiv = document.getElementById("suppliers_table_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "suppliers_table_length" div and its select element
            var existingDiv = document.getElementById("suppliers_table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }

            // Open modal to edit Supplier
            SuppliersEditModal();
        };

        // Add New Supplier
        function SuppliersAddButton() {
            $.ajax({
                type: 'POST',
                url: "{{ route('suppliers.create') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    code:           document.getElementById("SuppliersAddCode").value,
                    name:           document.getElementById("SuppliersAddName").value,
                    address:        document.getElementById("SuppliersAddAddress").value,
                    contact_person: document.getElementById("SuppliersAddContactPerson").value,
                    phone:          document.getElementById("SuppliersAddPhone").value,
                    fax:            document.getElementById("SuppliersAddFax").value,
                    email:          document.getElementById("SuppliersAddEmail").value,
                    description:    document.getElementById("SuppliersAddDecription").value,
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#SuppliersAddModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("SuppliersAddCode").value = "";
                    document.getElementById("SuppliersAddName").value = "";
                    document.getElementById("SuppliersAddAddress").value = "";
                    document.getElementById("SuppliersAddContactPerson").value = "";
                    document.getElementById("SuppliersAddPhone").value = "";
                    document.getElementById("SuppliersAddFax").value = "";
                    document.getElementById("SuppliersAddEmail").value = "";
                    document.getElementById("SuppliersAddDecription").value = "";

                    // Reload table
                    $('#suppliers_table').DataTable().ajax.reload();
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

        // Open modal to edit supplier
        function SuppliersEditModal() {
            // Remove previous click event listeners
            $(document).off('click', "[id^='suppliers_table'] tbody tr td:not(:last-child)");

            $(document).on('click', "[id^='suppliers_table'] tbody tr td:not(:last-child)", function() {
                // Place values to edit form fields in the modal
                document.getElementById("SuppliersEditName").value = $(event.target).closest('tr').find('td:nth-child(' + '2' + ')').text();
                document.getElementById("SuppliersEditAddress").value = $(event.target).closest('tr').find('td:nth-child(' + '3' + ')').text();
                document.getElementById("SuppliersEditContactPerson").value = $(event.target).closest('tr').find('td:nth-child(' + '4' + ')').text();
                document.getElementById("SuppliersEditPhone").value = $(event.target).closest('tr').find('td:nth-child(' + '5' + ')').text();
                document.getElementById("SuppliersEditFax").value = $(event.target).closest('tr').find('td:nth-child(' + '6' + ')').text();
                document.getElementById("SuppliersEditEmail").value = $(event.target).closest('tr').find('td:nth-child(' + '7' + ')').text();
                document.getElementById("SuppliersEditDecription").value = $(event.target).closest('tr').find('td:nth-child(' + '8' + ')').text();
                
                // Grab row Supplier id
                // originalSuppliersId = $(event.target).closest('tr').find('td:nth-child(8) a').attr('id').split('-')[1];
                originalSuppliersId = $(event.target).closest('tr').find('td:nth-child(' + '1' + ')').find('a').attr('id');

                // Open modal
                var element = "#SuppliersEditModal";
                openAltEditorModal(element);
            });
        }

        // Edit Supplier
        function editSuppliers() {
            var name = document.getElementById("SuppliersEditName").value;
            var address = document.getElementById("SuppliersEditAddress").value;
            var contact_person = document.getElementById("SuppliersEditContactPerson").value;
            var phone = document.getElementById("SuppliersEditPhone").value;
            var fax = document.getElementById("SuppliersEditFax").value;
            var email = document.getElementById("SuppliersEditEmail").value;
            var description = document.getElementById("SuppliersEditDecription").value;

            $.ajax({
                type: 'POST',
                url: "{{ route('suppliers.edit') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    name: name,
                    address: address,
                    contact_person: contact_person,
                    phone: phone,
                    fax: fax,
                    email: email,
                    description: description,
                    original_supplier_id: originalSuppliersId
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#SuppliersEditModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully updated.", "#91C714");

                    // Clean fields
                    document.getElementById("SuppliersEditName").value = "";
                    document.getElementById("SuppliersEditAddress").value = "";
                    document.getElementById("SuppliersEditContactPerson").value = "";
                    document.getElementById("SuppliersEditPhone").value = "";
                    document.getElementById("SuppliersEditFax").value = "";
                    document.getElementById("SuppliersEditEmail").value = "";
                    document.getElementById("SuppliersEditDecription").value = "";

                    // Reload table
                    $('#suppliers_table').DataTable().ajax.reload();
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

        // Delete Supplier
        function SuppliersDeleteButton() {
            var deleteSupplierId = lastClickedLink.split("-")[1];

            $.ajax({
                type: 'POST',
                url: "{{ route('suppliers.delete') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    delete_supplier_id: deleteSupplierId
                },
                success: function (response) {
                    // Close modal after successfully deleted
                    var element = "#SuppliersDeleteModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully deleted.", "#91C714");

                    // Reload table
                    $('#suppliers_table').DataTable().ajax.reload();
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