@extends('layouts.main')

@section('title')
<title>Chulia Middle East - VendorCompany</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Vendor Company
    </h2>
</div>
<div class="intro-y box p-5 mt-5">
    <!-- BEGIN: Filter & Add New User -->
    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
        
        <!-- BEGIN: Filter -->
        <!--<form class="xl:flex sm:mr-auto">
            <div class="row sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Role</label>
                <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputEmployeeRole">
                    <option value="All">All</option>
                    <option value="superadmin">Superadmin</option>
                    <option value="Employee_OCC_Admin">OCC Admin</option>
                    <option value="Employee_OCC_Operator">OCC Operator</option>
                    <option value="Employee_Supervisor">In-House Supervisor</option>
                    <option value="Employee_Technician">In-House Technician</option>
                </select>
            </div>

            <div class="mt-2 xl:mt-0">
                <button type="button" class="button w-full sm:w-16 bg-theme-32 text-white" id="filterEmployeeButton">Filter</button>
            </div>
        </form>-->            
        <!-- END: Filter -->

        <!-- BEGIN: Add New User Button -->
        <div class="text-center"> 
            <a href="javascript:;" data-toggle="modal" data-target="#vendorCompanyAddModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white" id="vendorCompanyAddModalButton">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add New Vendor Company
            </a> 
        </div>
        <!-- END: Add New User Button -->
    </div>
    <!-- END: Filter & Add New User -->

    <!-- BEGIN: Vendor Company List -->
    <div class="overflow-x-auto scrollbar-hidden">
        <table class="table table-report mt-5" id="vendorCompany_table">
            <thead>
                <tr class="bg-theme-1 text-white">
                    <th>Name</th>
                    <th>Services Offered</th>
                    <th>Contact</th> 
                    <th>Address</th>
                    <th>Number of Employee</th>
                    <th>Description</th>
                    <th class="dt-exclude-export dt-no-sort">Actions</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <!-- END: Vendor Company List -->
</div>
@endsection('app_content')

@section('modal_content')
<!-- BEGIN: Vendor Company Add Modal -->
<div class="modal rounded-sm" id="vendorCompanyAddModal"> 
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5"> 
            <h2 class="font-medium text-base mr-auto">Add New Vendor Company</h2>
        </div>
        
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">    
                    <label>Vendor Company Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Vendor Company Name" id="vendorCompanyAddName" required>
                </div>

                <div class="col-span-12 sm:col-span-12">    
                    <label>Services Offered</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Services" id="vendorCompanyAddServicesOffered" required>
                </div>

                <div class="col-span-12 sm:col-span-12">    
                    <label>Contact</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="0123456789" id="vendorCompanyAddPhone" required>
                </div>
                
                <div class="col-span-12 sm:col-span-12">    
                    <label>Address</label>
                    <textarea class="input w-full border mt-2 flex-1" placeholder="Address" id="vendorCompanyAddAddress" required></textarea>
                </div>
                
                <div class="col-span-12 sm:col-span-12">    
                    <label>Description</label>
                    <textarea class="input w-full border mt-2 flex-1" placeholder="Description" id="vendorCompanyAddDescription"></textarea>
                </div>
            </div>

            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="vendorCompanyAddButton">Save</button>
            </div>
        </form>    
    </div> 
</div>
<!-- END: Vendor Company Add Modal -->

<!-- BEGIN: Vendor Company Edit Modal -->
<div class="modal" id="vendorCompanyEditModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Edit Vendor Company</h2>
        </div>

        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Vendor Company Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Vendor Company Name" id="vendorCompanyEditName" required>
                </div>

                <div class="col-span-12 sm:col-span-12">
                    <label>Services Offered</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Services Offered" id="vendorCompanyEditServicesOffered" required>
                </div>

                <div class="col-span-12 sm:col-span-12">
                    <label>Contact</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="0123456789" id="vendorCompanyEditPhone" required>
                </div>

                <div class="col-span-12 sm:col-span-12">
                    <label>Address</label>
                    <textarea class="input w-full border mt-2 flex-1" placeholder="Address" id="vendorCompanyEditAddress" required></textarea>
                </div>

                <div class="col-span-12 sm:col-span-12">
                    <label>Description</label>
                    <textarea class="input w-full border mt-2 flex-1" placeholder="Description" id="vendorCompanyEditDescription"></textarea>
                </div>
            </div>

            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="vendorCompanyEditButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Vendor Company Edit Modal -->

<!-- BEGIN: Vendor Company Delete Modal -->
<div class="modal" id="vendorCompanyDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm deleting the vendor company? This process cannot be undone.</div>
        </div>
        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="vendorCompanyDeleteButton">Delete</button>
        </div>
    </div>
</div>
<!-- END: Vendor Company Delete Modal -->
@endsection('modal_content')

@section('script')
<script>  	
    $(document).ready(function() {
        //Global variable
        var delete_vendorCompany_id;
        var original_vendorCompany_name;

        // Listen to below buttons
        document.getElementById("vendorCompanyAddButton").addEventListener("click", vendorCompanyAddButton);
        document.getElementById("vendorCompanyDeleteButton").addEventListener("click", vendorCompanyDeleteButton);

        // When page first loads, load the in-house users table
        filterVendorCompanyButton();

        function filterVendorCompanyButton(){
            vendorCompanyDatatable();
            deleteAltEditorModal();
        };

        //When any sumbit button is clicked
        (function(){
            var vendorCompany_table = $('#vendorCompany_table')[0].altEditor;

            document.getElementById('vendorCompanyAddButton').addEventListener('click', function(e) {
                // Prevent the default from submission behavior
                e.preventDefault();
            });

            document.getElementById('vendorCompanyEditButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Edit vendor company  
                editVendorCompany();
            });
        })();

        // When any delete button is clicked
        (function() {
            var lastClickedLink;

            // Store the ID of the last clicked link when it's triggered and stored id in delete button
            $(document).on('click', "[data-target='#vendorCompanyDeleteModal']", function() {
                lastClickedLink = $(this).attr('id');
                delete_vendorCompany_id = lastClickedLink.split("-")[2];
            });
            
            // // Use the stored ID when the Delete button is clicked
            // $('#vendorCompanyDeleteButton').on('click', function() {
            //     delete_vendorCompany_id = lastClickedLink.split("-")[2];
            //     console.log(delete_vendorCompany_id+'qwe');
            // });
        })();

        // Initiate altEditor for inhouse users datatable
        function initAltEditorEditVendorCompany() {
            // Remove previous click event listeners
            $(document).off('click', "[id^='vendorCompany_table'] tbody tr td:not(:last-child)");

            $(document).on('click', "[id^='vendorCompany_table'] tbody tr td:not(:last-child)", function() {
                // Assign original username to global variable
                original_vendorCompany_name = $(event.target).closest('tr').find('td:nth-child(' + '1' + ')').text();

                // Place values to edit form fields in the modal
                document.getElementById("vendorCompanyEditName").value              = $(event.target).closest('tr').find('td:nth-child(' + '1' + ')').text();
                document.getElementById("vendorCompanyEditServicesOffered").value   = $(event.target).closest('tr').find('td:nth-child(' + '2' + ')').text();
                document.getElementById("vendorCompanyEditPhone").value             = $(event.target).closest('tr').find('td:nth-child(' + '3' + ')').text();
                document.getElementById("vendorCompanyEditAddress").value           = $(event.target).closest('tr').find('td:nth-child(' + '4' + ')').text();
                document.getElementById("vendorCompanyEditDescription").value       = $(event.target).closest('tr').find('td:nth-child(' + '6' + ')').text();

                // Open modal
                var element = "#vendorCompanyEditModal";
                openAltEditorModal(element);
            });
        }

        // Delete altEditor modal
        function deleteAltEditorModal() {
            // Replace "altEditor-modal-" with the known part of the ID
            var pattern = "altEditor-modal-";

            // Find all elements whose IDs match the pattern
            var elementsToDelete = document.querySelectorAll('[id^="' + pattern + '"]');

            // Loop through the matched elements and delete them
            if (elementsToDelete.length > 0) {
                // Remove the element
                elementsToDelete.forEach(function(element) {
                    element.remove();
                });
            }
        };
        
        // Open altEditor modal
        function openAltEditorModal(element) {
            cash(element).modal('show');
        };

        // Close altEditor modal
        function closeAltEditorModal(element) {
            cash(element).modal('hide');
        };

        // Setup the vendor company datatable
        function vendorCompanyDatatable() {
            const dt = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName     = `Vendor_Company_List_${formattedDate}_${formattedTime}`;

            const table = $('#vendorCompany_table').DataTable({
                altEditor: true, // Enable altEditor
                autoWidth: false,
                destroy: true,
                debug: true,
                processing: true,
                scrollX: true,
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
                    url: "{{ route('vendorCompany.list') }}",
                    dataType: "json",
                    type: "POST",
                    data: function(d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        //d.role = filterEmployeeRole;
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
                drawCallback: function(settings){
                    //Fix the length of description column
                    $(this.api().column(5).nodes()).css('max-width', '450px');
                    $(this.api().column(5).nodes()).css('word-wrap', 'break-word');
                },
                columns: [{
                        data: "name",
                    },
                    {
                        data: "services_offered",
                    },
                    {
                        data: "phone",
                    },
                    {
                        data: "address",
                    },
                    {
                        data: "number_of_employee",
                    },
                    {
                        data: "description",
                    },
                    {
                        data: "id",
                        render: function(data, type, row) {
                            let element = `
                            <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#vendorCompanyDeleteModal" id="delete-vendorCompany-` + data + `">
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
                columnDefs: [{
                        targets: 'dt-no-sort',
                        orderable: false
                    }
                ],
            });

            // Add classes to the "dt-buttons" div
            var dtButtonsDiv = document.querySelector(".dt-buttons");
            if (dtButtonsDiv) {
                dtButtonsDiv.classList.add("mt-2");
            }

            // Update styling for the filter input
            var filterDiv = document.getElementById("vendorCompany_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv = document.getElementById("vendorCompany_table_info");
            var paginateDiv = document.getElementById("vendorCompany_table_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "vendorCompany_table_length" div and its select element
            var existingDiv = document.getElementById("vendorCompany_table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }

            // Update styling for the first "dataTables_scrollBody" if enable the scrollX feature for DataTable
            var existingScrollBody = document.querySelector("div.dataTables_scrollBody")
            if(existingScrollBody){
                existingScrollBody.style.marginTop = "-20px";
            };

            // AltEditor
            initAltEditorEditVendorCompany();
        };

        // Add New Vendor Company
        function vendorCompanyAddButton() {
            $.ajax({
                type: 'POST',
                url: "{{ route('vendorCompany.create') }}",
                data: {
                    _token              : $('meta[name="csrf-token"]').attr('content'),
                    name                : document.getElementById("vendorCompanyAddName").value,
                    address             : document.getElementById("vendorCompanyAddAddress").value,
                    phone               : document.getElementById("vendorCompanyAddPhone").value,
                    description         : document.getElementById("vendorCompanyAddDescription").value,
                    services_offered    : document.getElementById("vendorCompanyAddServicesOffered").value
                },

                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#vendorCompanyAddModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("vendorCompanyAddName").value = "";
                    document.getElementById("vendorCompanyAddAddress").value = "";
                    document.getElementById("vendorCompanyAddPhone").value = "";
                    document.getElementById("vendorCompanyAddDescription").value = "";
                    document.getElementById("vendorCompanyAddServicesOffered").value = "";

                    // Reload table
                    $('#vendorCompany_table').DataTable().ajax.reload();
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

        //Edit Vendor Company
        function editVendorCompany(){
            var name             = document.getElementById("vendorCompanyEditName").value;
            var services_offered = document.getElementById("vendorCompanyEditServicesOffered").value;
            var phone            = document.getElementById("vendorCompanyEditPhone").value;
            var address          = document.getElementById("vendorCompanyEditAddress").value;
            var description      = document.getElementById("vendorCompanyEditDescription").value;

            $.ajax({
                type: 'POST',
                url: "{{ route('vendorCompany.edit') }}",
                data: {
                    _token                      : $('meta[name="csrf-token"]').attr('content'),
                    original_vendorCompany_name : original_vendorCompany_name,
                    name                        : name,
                    services_offered            : services_offered,
                    phone                       : phone,
                    address                     : address,
                    description                 : description
                },
                success: function(response) {
                    console.log(response);
                    // Close modal after successfully edited
                    var element = "#vendorCompanyEditModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully edited.", "#91C714");

                    // Clean fields
                    document.getElementById("vendorCompanyEditName").value = "";
                    document.getElementById("vendorCompanyEditServicesOffered").value = "";
                    document.getElementById("vendorCompanyEditPhone").value = "";
                    document.getElementById("vendorCompanyEditAddress").value = "";
                    document.getElementById("vendorCompanyEditDescription").value = "";

                    // Reload table
                    $('#vendorCompany_table').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    // Display the validation error message
                    var response    = JSON.parse(xhr.responseText);
                    var error       = "Error: " + response.error;

                    // Show fail toast
                    window.showSubmitToast(error, "#D32929");
                }
            });
        };
        
        // Delete Vendor Company
        function vendorCompanyDeleteButton() {
            $.ajax({
                type: 'POST',
                url: "{{ route('vendorCompany.delete') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    delete_vendorCompany_id: delete_vendorCompany_id
                },
                success: function(response) {
                    // Close modal after successfully deleted
                    var element = "#vendorCompanyDeleteModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully deleted.", "#91C714");

                    // Reload table
                    $('#vendorCompany_table').DataTable().ajax.reload();
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
    })
</script>
@endsection('script')