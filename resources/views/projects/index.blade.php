@extends('layouts.main')

@section('title')
<title>Chulia Middle East - Project</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Project
    </h2>
</div>

<div class="intro-y box p-5 mt-5">
    <div class="pos col-span-12 lg:col-span-4">
        <!-- BEGIN: Project -->
        <div>
            <!-- BEGIN: Filter & Add Project -->
            <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                <!-- BEGIN: Filter -->
                <form class="xl:flex sm:mr-auto">
                    <div class="sm:flex items-center sm:mr-4">
                        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Company Name</label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputProjectCompany">
                            <option value="all">All</option>
                        @foreach ($clientcompany as $clientcomp)
                            <option value="{{ $clientcomp->id }}">{{ $clientcomp->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="sm:flex items-center sm:mr-4">
                        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Project Type</label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputProjectType">
                            <option value="all">All</option>
                            <option value="open">Open</option>
                            <option value="new">New</option>
                            <option value="renew">Renew</option>
                        </select>
                    </div>
                    <div class="mt-2 xl:mt-0">
                        <button type="button" class="button w-full sm:w-16 bg-theme-32 text-white" id="filterProjectButton">Filter</button>
                    </div>
                </form>
                <!-- END: Filter -->

                <!-- BEGIN: Add Project -->
                <div class="text-center">
                    <a href="javascript:;" data-toggle="modal" data-target="#projectAddModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add New Project
                    </a>
                </div>
                <!-- END: Add Project -->
            </div>
            <!-- END: Filter & Add Project -->

            <!-- BEGIN: Project List -->
            <!-- <div class="overflow-x-auto scrollbar-hidden"> -->
            <div class="table-responsive overflow-x-auto scrollbar-hidden">
                <table class="table mt-5" id="projects_table">
                    <thead>
                        <tr class="bg-theme-32 text-white">
                            <th style="width: 15%;">Project Prefix</th>
                            <th style="width: 15%;">From Date</th>
                            <th style="width: 15%;">To Date</th>
                            <th style="width: 10%;">Type</th>
                            <th style="width: 25%;">Client Company Name</th>
                            <th style="width: 15%;">Created at</th>
                            <th style="width: 5%;" class="dt-exclude-export dt-no-sort ">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- END: Project List -->
        </div>
        <!-- END: Project -->
    </div>
</div>
@endsection('app_content')

<!-- <th class="text-center dt-no-sort">Project Status</th> -->

@section('modal_content')
<!-- BEGIN: Project Add Modal -->
<div class="modal" id="projectAddModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Add Project</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Project Prefix</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Project Prefix" id="projectAddPrefix" required>
                </div>

                <div class="col-span-12 sm:col-span-12">
                    <label>From and To Date</label>
                    <input class="datepicker input w-full border block mx-auto" data-daterange="true" id="projectFromToDate" required> 
                </div>
                                                                          
                <div class="col-span-12 sm:col-span-12">
                    <label>Type</label>
                    <select class="input w-full border mt-2 flex-1" placeholder="Type" id="projectAddType" required>
                        <option disabled selected value>Select an option</option>
                        <option value="new">New</option>
                        <option value="renew">Renew</option>
                        <option value="open">Open</option>
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Client Company Name</label>
                    <select class="input w-full border mt-2 flex-1" placeholder="Client Company ID" id="projectAddClientCompanyID" required>
                            <option disabled selected value>Select an option</option>
                        @foreach ($clientcompany as $clientcomp)
                            <option value="{{ $clientcomp->id }}">{{ $clientcomp->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="projectAddButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Project Add Modal -->

<!-- BEGIN: Project Edit Modal -->
<div class="modal" id="projectEditModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Edit Project</h2>
        </div>    
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Project Prefix</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Project Prefix" id="projectEditPrefix" required>
                </div>

                <div class="col-span-12 sm:col-span-12">
                    <label>From and To Date</label>
                    <input class="datepicker input w-full border block mx-auto" data-daterange="true" id="projectEditFromToDate" required> 
                </div>

                <div class="col-span-12 sm:col-span-12">
                    <label>Type</label>
                    <select class="input w-full border mt-2 flex-1" placeholder="Type" id="projectEditType" required>
                        <option value="new">New</option>
                        <option value="renew">Renew</option>
                        <option value="open">Open</option>
                    </select>
                </div>
            </div>
            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="projectEditButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Project Edit Modal -->

<!-- BEGIN: Project Delete Modal -->
<div class="modal" id="projectDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm deleting this project? This process cannot be undone.</div>
        </div>
        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="projectDeleteButton">Delete</button>
        </div>
    </div>
</div>
<!-- END: Project Delete Modal -->
@endsection('modal_content')

@section('script')
<script>
    $(document).ready(function() {
        
        // Global variables
        var filterProjectCompany;
        var filterProjectType;
        var originalProjectId;
        var lastClickedLink;

        // Listen to below buttons
        document.getElementById("filterProjectButton").addEventListener("click", filterProjectButton);
        document.getElementById("projectAddButton").addEventListener("click", projectAddButton);
        document.getElementById("projectDeleteButton").addEventListener("click", projectDeleteButton);

        // When "filterProjectButton" button is clicked, initiate initProjectDatatable
        function filterProjectButton() {
            filterProjectCompany = document.getElementById("inputProjectCompany").value;
            filterProjectType = document.getElementById("inputProjectType").value;
            initProjectDatatable(filterProjectCompany, filterProjectType);
        };

        // When page first loads, load table
        filterProjectButton();

        // When any submit button is clicked
        (function() {
            var projects_table = $('#projects_table')[0].altEditor;

            document.getElementById('projectAddButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();
            });

            document.getElementById('projectEditButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Edit client company
                editProject();
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

        // Setup the project datatable
        function initProjectDatatable() {
            const dt = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName = `Project_List_${formattedDate}_${formattedTime}`;

            const table = $('#projects_table').DataTable({
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
                    url: "{{ route('projects.list') }}",
                    dataType: "json",
                    type: "POST",
                    data: function(d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        d.company = filterProjectCompany;
                        d.type = filterProjectType;
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
                        data: "project_prefix",
                    },
                    {
                        data: "from_date",
                    },
                    {
                        data: "to_date",
                    },
                    {
                        data: "type",
                    },
                    {
                        data: "client_company_name",
                    },
                    {
                        data: "created_at",
                    },
                    {
                        data: "id",
                        render: function(data, type, row) {
                            let element = `
                            <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#projectDeleteModal" id="delete-` + data + `">
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
            var filterDiv = document.getElementById("projects_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv = document.getElementById("projects_table_info");
            var paginateDiv = document.getElementById("projects_table_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "projects_table_length" div and its select element
            var existingDiv = document.getElementById("projects_table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }

            // Open modal to edit client company
            projectEditModal();
        };

        // Add New Project
        function projectAddButton() {
            $.ajax({
                type: 'POST',
                url: "{{ route('projects.create') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    project_prefix: document.getElementById("projectAddPrefix").value,
                    from_to_date: document.getElementById("projectFromToDate").value,
                    type: document.getElementById("projectAddType").value,
                    client_company_id: document.getElementById("projectAddClientCompanyID").value 
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#projectAddModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("projectAddPrefix").value = "";
                    document.getElementById("projectFromToDate").value = "";
                    document.getElementById("projectAddType").value = "";
                    document.getElementById("projectAddClientCompanyID").value = "";

                    // Reload table
                    $('#projects_table').DataTable().ajax.reload();
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

        // Open modal to edit client company
        function projectEditModal() {
            
            // Remove previous click event listeners
            $(document).off('click', "[id^='projects_table'] tbody tr td:not(:last-child)");

            $(document).on('click', "[id^='projects_table'] tbody tr td:not(:last-child)", function() {
                // Place values to edit form fields in the modal
                document.getElementById("projectEditPrefix").value = $(event.target).closest('tr').find('td:nth-child(' + '1' + ')').text();
                var from_date = $(event.target).closest('tr').find('td:nth-child(' + '2' + ')').text();
                var to_date = $(event.target).closest('tr').find('td:nth-child(' + '3' + ')').text();
                // document.getElementById("projectEditFromDate").value = $(event.target).closest('tr').find('td:nth-child(' + '2' + ')').text();
                // document.getElementById("projectEditToDate").value = $(event.target).closest('tr').find('td:nth-child(' + '3' + ')').text();
                document.getElementById("projectEditType").value = $(event.target).closest('tr').find('td:nth-child(' + '4' + ')').text();
                
                
                // Join the dates with a delimiter (e.g., '-')
                var date_range = from_date + ' - ' + to_date;
                document.getElementById("projectEditFromToDate").value = date_range; // Optionally, you can store the joined range in a hidden field


                // Grab row client company id
                originalProjectId = $(event.target).closest('tr').find('td:nth-child(7) a').attr('id').split('-')[1];
                
                // Open modal
                var element = "#projectEditModal";
                openAltEditorModal(element);
            });
        }

        

        // Edit Project
        function editProject() {
            var project_prefix = document.getElementById("projectEditPrefix").value;
            var from_to_date = document.getElementById("projectEditFromToDate").value;
            var type = document.getElementById("projectEditType").value;

            $.ajax({
                type: 'POST',
                url: "{{ route('projects.edit') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    project_prefix: project_prefix,
                    from_to_date: from_to_date,
                    type: type,
                    original_project_id: originalProjectId,
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#projectEditModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("projectEditPrefix").value = "";
                    document.getElementById("projectEditFromToDate").value = "";
                    document.getElementById("projectEditType").value = "";

                    // Reload table
                    $('#projects_table').DataTable().ajax.reload();
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

        // Store the ID of the last clicked modal when it's triggered
        (function() {
            $(document).on('click', "[data-toggle='modal']", function() {
                lastClickedLink = $(this).attr('id');
            });
        })();

        // Delete Project
        function projectDeleteButton() {
            var deleteProjectId = lastClickedLink.split("-")[1];

            $.ajax({
                type: 'POST',
                url: "{{ route('projects.delete') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    delete_project_id: deleteProjectId
                },
                success: function (response) {
                    // Close modal after successfully deleted
                    var element = "#projectDeleteModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully deleted.", "#91C714");

                    // Reload table
                    $('#projects_table').DataTable().ajax.reload();
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