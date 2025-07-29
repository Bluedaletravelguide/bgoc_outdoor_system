@extends('layouts.main')

@section('title')
<title>BGOC Outdoor System - Client Company</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Client Company
    </h2>
</div>

<div class="intro-y box p-5 mt-5">
    <div class="pos col-span-12 lg:col-span-4">
        <!-- BEGIN: Client Company -->
        <div>
            <!-- BEGIN: Filter & Add Client Company -->
            <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                <!-- BEGIN: Filter -->
                <form class="xl:flex sm:mr-auto">
                    <div class="sm:flex items-center sm:mr-4">
                        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Company Status</label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputContractStatus">
                            <option value="all">All</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="mt-2 xl:mt-0">
                        <button type="button" class="button w-full sm:w-16 bg-theme-32 text-white" id="filterClientCompanyButton">Filter</button>
                    </div>
                </form>
                <!-- END: Filter -->

                <!-- BEGIN: Add Client Company -->
                <div class="text-center">
                    <a href="javascript:;" data-toggle="modal" data-target="#clientCompanyAddModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add New Client Company
                    </a>
                </div>
                <!-- END: Add Client Company -->
            </div>
            <!-- END: Filter & Add Client Company -->

            <!-- BEGIN: Client Company List -->
            <div class="overflow-x-auto scrollbar-hidden">
                <table class="table mt-5" id="client_company_table">
                    <thead>
                        <tr class="bg-theme-32 text-white">
                            <th>No</th>
                            <th>Company Prefix</th>
                            <th>Company Name</th>
                            <th>Address</th>
                            <th>Phone No.</th>
                            <!-- <th class="text-center dt-no-sort">Contract Status</th>
                            <th>Contract Type</th> -->
                            <th class="dt-exclude-export dt-no-sort ">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- END: Client Company List -->
        </div>
        <!-- END: Client Company -->
    </div>
</div>
@endsection('app_content')

@section('modal_content')
<!-- BEGIN: Client Company Add Modal -->
<div class="modal" id="clientCompanyAddModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Add Client Company</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Company Prefix</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Company Prefix" id="clientCompanyAddPrefix" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Company Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Company Name" id="clientCompanyAddName" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Company Address</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Company Address" id="clientCompanyAddAddress" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Phone No.</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Phone No." id="clientCompanyAddPhone" required>
                </div>
            </div>
            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">Add PIC</h2>
            </div>
            <div id="picContainer">
                <div class="pic">
                    <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label>Name</label>
                            <input type="text" class="input w-full border mt-2" placeholder="Name" name="pic_names[]" required>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Email</label>
                            <input type="text" class="input w-full border mt-2" placeholder="Email" name="pic_emails[]" required>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Phone No.</label>
                            <input type="text" class="input w-full border mt-2" placeholder="Phone No." name="pic_phones[]" required>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Designation</label>
                            <div class="flex items-center mt-2">
                                <input type="text" class="input w-full border" placeholder="Designation" name="pic_designations[]" required>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <div class="flex items-center mt-2">
                                <a href="javascript:void(0);" class="button bg-theme-6 text-white " onclick="removePIC(this)">
                                    Remove
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="button" onclick="picAdd()" class="button w-20 bg-theme-1 text-white mt-2">Add PIC</button>
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="addClientCompany">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Client Company Add Modal -->

<!-- BEGIN: Client Company Edit Modal -->
<div class="modal" id="clientCompanyEditModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Edit Client Company</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Company Prefix</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Company Prefix" id="clientCompanyEditPrefix" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Company Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Company Name" id="clientCompanyEditName" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Company Address</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Company Address" id="clientCompanyEditAddress" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Phone No.</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Phone No." id="clientCompanyEditPhone" required>
                </div>
            </div>
            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="clientCompanyEditButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Client Company Edit Modal -->

<!-- BEGIN: Client Company Delete Modal -->
<div class="modal" id="clientCompanyDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm deleting the client company? This process cannot be undone.</div>
        </div>
        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="clientCompanyDeleteButton">Delete</button>
        </div>
    </div>
</div>
<!-- END: Client Company Delete Modal -->
@endsection('modal_content')

@section('script')
<script>

    // Add a new PIC input field
    function picAdd() {
        var picTemplate = `
            <div class="pic">
                <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <label>Name</label>
                        <input type="text" class="input w-full border mt-2" placeholder="Name" name="pic_names[]" required>
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label>Email</label>
                        <input type="text" class="input w-full border mt-2" placeholder="Phone No." name="pic_emails[]" required>
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label>Phone No.</label>
                        <input type="text" class="input w-full border mt-2" placeholder="Phone No." name="pic_phones[]" required>
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label>Designation</label>
                        <div class="flex items-center mt-2">
                            <input type="text" class="input w-full border" placeholder="Designation" name="pic_designations[]" required>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <div class="flex items-center mt-2">
                            <a href="javascript:void(0);" class="button bg-theme-6 text-white " onclick="removePIC(this)">
                                Remove
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $("#picContainer").append(picTemplate);
    }

    // Remove a pic input field in edit modal
    function removePIC(button) {
        var container = $(button).closest('.pic');
        var inputField = container.find('input');
        var hasData = inputField.val();

        console.log("data:", inputField);

        // Remove the subcategory field
        container.remove();

        // If it had existing data, remove it from the modal
        if (hasData) {
            inputField.remove();
        }
    }

    $(document).ready(function() {
        // Global variables
        var filterClientCompanyStatus;
        var filterContractType;
        var originalCompanyId;
        var lastClickedLink;

        // Listen to below buttons
        document.getElementById("filterClientCompanyButton").addEventListener("click", filterClientCompanyButton);
        document.getElementById("addClientCompany").addEventListener("click", addClientCompany);
        document.getElementById("clientCompanyDeleteButton").addEventListener("click", clientCompanyDeleteButton);

        // When "filterClientCompanyButton" button is clicked, initiate initClientCompanyDatatable
        function filterClientCompanyButton() {
            filterClientCompanyStatus = document.getElementById("inputContractStatus").value;
            // filterContractType = document.getElementById("inputContractType").value;
            initClientCompanyDatatable(filterClientCompanyStatus, filterContractType);
        };

        // When page first loads, load table
        filterClientCompanyButton();

        // When any submit button is clicked
        (function() {
            var client_company_table = $('#client_company_table')[0].altEditor;

            document.getElementById('addClientCompany').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();
            });

            document.getElementById('clientCompanyEditButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Edit client company
                editClientCompany();
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

        // Setup the client company datatable
        function initClientCompanyDatatable() {
            const dt = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName = `Client_Company_List_${formattedDate}_${formattedTime}`;

            const table = $('#client_company_table').DataTable({
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
                    url: "{{ route('client-company.list') }}",
                    dataType: "json",
                    type: "POST",
                    data: function(d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        d.status = filterClientCompanyStatus;
                        d.type = filterContractType;
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
                        data: "company_prefix",
                    },
                    {
                        data: "name",
                    },
                    {
                        data: "address",
                    },
                    {
                        data: "phone",
                    },
                    // {
                    //     data: "status",
                    //     type: "readonly",
                    //     render: function(data, type, row) {
                    //         let element = ``
                    //         if (data == 1){
                    //             element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-9 text-white">ACTIVE</a>`;
                    //         } else if (data == 0){
                    //             element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-6 text-white">INACTIVE</a>`;
                    //         }
                            
                    //         return element;
                    //     }
                    // },
                    // {
                    //     data: "project_status",
                    //     render: function(data, type, row) {
                    //         var element;

                    //         if (data == "Active") {
                    //             element = `<div class="cursor-pointer rounded-full bg-theme-9 px-2 py-1 text-xs font-medium text-center text-white">
                    //                             Active
                    //                         </div>`;
                    //         } else {
                    //             element = `<div class="cursor-pointer rounded-full bg-theme-13 px-2 py-1 text-xs font-medium text-center text-white">
                    //                             Inactive
                    //                         </div>`;
                    //         }

                    //         return element;
                    //     }
                    // },
                    // {
                    //     data: "project_type",
                    // },
                    {
                        data: "id",
                        render: function(data, type, row) {
                            let element = `
                            <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#clientCompanyDeleteModal" id="delete-` + data + `">
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
            var filterDiv = document.getElementById("client_company_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv = document.getElementById("client_company_table_info");
            var paginateDiv = document.getElementById("client_company_table_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "client_company_table_length" div and its select element
            var existingDiv = document.getElementById("client_company_table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }

            // Open modal to edit client company
            clientCompanyEditModal();
        };

        // Add New Client Company
        function addClientCompany() {
            let pics = [];
            $('#picContainer .pic').each(function () {
                pics.push({
                    name: $(this).find('input[name="pic_names[]"]').val(),
                    email: $(this).find('input[name="pic_emails[]"]').val(),
                    phone: $(this).find('input[name="pic_phones[]"]').val(),
                    designation: $(this).find('input[name="pic_designations[]"]').val()
                });
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('client-company.create') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    prefix: $('#clientCompanyAddPrefix').val(),
                    name: $('#clientCompanyAddName').val(),
                    address: $('#clientCompanyAddAddress').val(),
                    companyPhone: $('#clientCompanyAddPhone').val(),
                    pics: pics
                },
                success: function(response) {
                    closeAltEditorModal("#clientCompanyAddModal");
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clear form
                    $('#clientCompanyAddModal input').val("");
                    $('#client_company_table').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    let response = JSON.parse(xhr.responseText);
                    window.showSubmitToast("Error: " + response.error, "#D32929");
                }
            });
        }


        // Open modal to edit client company
        function clientCompanyEditModal() {
            // Remove previous click event listeners
            $(document).off('click', "[id^='client_company_table'] tbody tr td:not(:last-child)");

            $(document).on('click', "[id^='client_company_table'] tbody tr td:not(:last-child)", function() {
                // Place values to edit form fields in the modal
                document.getElementById("clientCompanyEditPrefix").value = $(event.target).closest('tr').find('td:nth-child(' + '2' + ')').text();
                document.getElementById("clientCompanyEditName").value = $(event.target).closest('tr').find('td:nth-child(' + '3' + ')').text();
                document.getElementById("clientCompanyEditAddress").value = $(event.target).closest('tr').find('td:nth-child(' + '4' + ')').text();
                document.getElementById("clientCompanyEditPhone").value = $(event.target).closest('tr').find('td:nth-child(' + '5' + ')').text();

                // Grab row client company id
                originalCompanyId = $(event.target).closest('tr').find('td:nth-child(6) a').attr('id').split('-')[1];

                // Open modal
                var element = "#clientCompanyEditModal";
                openAltEditorModal(element);
            });
        }

        // Edit Client Company
        function editClientCompany() {
            var prefix = document.getElementById("clientCompanyEditPrefix").value;
            var name = document.getElementById("clientCompanyEditName").value;
            var address = document.getElementById("clientCompanyEditAddress").value;
            var phone = document.getElementById("clientCompanyEditPhone").value;

            $.ajax({
                type: 'POST',
                url: "{{ route('client-company.edit') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    prefix: prefix,
                    name: name,
                    id: originalCompanyId,
                    address: address,
                    companyPhone: companyPhone
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#clientCompanyEditModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("clientCompanyEditPrefix").value = "";
                    document.getElementById("clientCompanyEditName").value = "";
                    document.getElementById("clientCompanyEditAddress").value = "";
                    document.getElementById("clientCompanyEditPhone").value = "";

                    // Reload table
                    $('#client_company_table').DataTable().ajax.reload();
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

        // Delete Client Company
        function clientCompanyDeleteButton() {
            var deleteCompanyId = lastClickedLink.split("-")[1];

            $.ajax({
                type: 'POST',
                url: "{{ route('client-company.delete') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: deleteCompanyId
                },
                success: function (response) {
                    // Close modal after successfully deleted
                    var element = "#clientCompanyDeleteModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully deleted.", "#91C714");

                    // Reload table
                    $('#client_company_table').DataTable().ajax.reload();
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