@extends('layouts.main')

@section('title')
<title>Chulia Middle East - Asset Category</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Asset Category
    </h2>
</div>

<div class="intro-y box p-5 mt-5">
    <div class="pos col-span-12 lg:col-span-4">
        <!-- BEGIN: Asset Category-->
        <div>
            <!-- BEGIN: Filter & Add Asset Category-->
            <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                
                <!-- BEGIN: Filter -->
                <form class="xl:flex sm:mr-auto">
                    <div class="sm:flex items-center sm:mr-4">
                        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Asset <br> Category</label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputAssetCategory">
                            <option selected value>All</option>
                            @foreach ($assetsCategory as $assetCat)
                            <option value="{{ $assetCat->id }}"> {{ $assetCat->code }} - {{ $assetCat->name }} </option>
                            @endforeach
                        </select>
                </div>
                    <div class="mt-2 xl:mt-0">
                        <button type="button" class="button w-full sm:w-16 bg-theme-32 text-white" id="filterAssetCategoryButton">Filter</button>
                    </div>
                </form>
                <!-- END: Filter -->

                <!-- BEGIN: Add Asset Category -->
                <div class="text-center">
                    <a href="javascript:;" data-toggle="modal" data-target="#AssetCategoryAddModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add New Asset Category
                    </a>
                </div>
                <!-- END: Add Asset Category -->
            </div>
            <!-- END: Filter & Add Asset Category-->

            <!-- BEGIN: Asset Category List -->
            <div class="overflow-x-auto scrollbar-hidden">
                <table class="table table-report mt-5" id="assetCategory_table">
                    <thead>
                        <tr class="bg-theme-32 text-white">
                            <th>Code</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th class="dt-exclude-export dt-no-sort ">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- END: Asset Category List -->
        </div>
        <!-- END: Asset Category-->
    </div>
</div>
@endsection('app_content')

@section('modal_content')
<!-- BEGIN: Asset Category Add Modal -->
<div class="modal" id="AssetCategoryAddModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Add Asset Category</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Code</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Code" id="AssetCategoryAddCode" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Asset Category Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Asset Category Name" id="AssetCategoryAddName" required>
                </div>
                
                <div class="col-span-12 sm:col-span-12">
                    <label>Asset Category Description</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Description" id="AssetCategoryAddDescription" required>
                </div>
            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="AssetCategoryAddButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Asset Category Add Modal -->

<!-- BEGIN: Asset Category Edit Modal -->
<div class="modal" id="AssetCategoryEditModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Edit Asset Category</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Asset Category Code</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Asset Category Name" id="AssetCategoryEditCode" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Asset Category Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Asset Category Name" id="AssetCategoryEditName" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Description</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Contact No." id="AssetCategoryEditDescription" required>
                </div>
            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="AssetCategoryEditButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Asset Category Edit Modal -->

<!-- BEGIN: Asset Category Delete Modal -->
<div class="modal" id="AssetCategoryDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm deleting the asset Category? This process cannot be undone.</div>
        </div>
        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="AssetCategoryDeleteButton">Delete</button>
        </div>
    </div>
</div>
<!-- END: Asset Category Delete Modal -->
@endsection('modal_content')

@section('script')
<script>
    $(document).ready(function() {
        // Global variables
        // var filterUserAccountStatus;
        var filterAssetCategory;
        var originalAssetCategoryId;
        var lastClickedLink;

        // Listen to below buttons
        document.getElementById("filterAssetCategoryButton").addEventListener("click", filterAssetCategoryButton);
        document.getElementById("AssetCategoryAddButton").addEventListener("click", AssetCategoryAddButton);
        document.getElementById("AssetCategoryDeleteButton").addEventListener("click", AssetCategoryDeleteButton);

        // When "filterAssetCategoryButton" button is clicked, initiate initAssetsDatatable
        function filterAssetCategoryButton() {
            // filterUserAccountStatus = document.getElementById("inputUserAccountStatus").value;
            filterAssetCategory = document.getElementById("inputAssetCategory").value;
            initAssetCategoryDatatable(filterAssetCategory);
        };

        // When page first loads, load table
        filterAssetCategoryButton();

        // When any submit button is clicked
        (function() {
            var assetCategory_table = $('#assetCategory_table')[0].altEditor;

            document.getElementById('AssetCategoryAddButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();
            });

            document.getElementById('AssetCategoryEditButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Edit filterAssetCategory
                editAssetCategory();
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

        // Setup the Asset Category datatable
        function initAssetCategoryDatatable() {
            const dt = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName = `AssetCategory_List_${formattedDate}_${formattedTime}`;

            const table = $('#assetCategory_table').DataTable({
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
                    url: "{{ route('assetCategory.list') }}",
                    dataType: "json",
                    type: "POST",
                    data: function(d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        // d.ustatus = filterUserAccountStatus;
                        d.assetcat = filterAssetCategory;
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
                    },
                    {
                        data: "name",
                    },
                    {
                        data: "description",
                    },
                    {
                        data: "created_at",
                    },
                    {
                        data: "updated_at",
                    },
                    {
                        data: "id",
                        render: function(data, type, row) {
                            let element = `
                            <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#AssetCategoryDeleteModal" id="delete-` + data + `">
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
            var filterDiv = document.getElementById("assetCategory_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv = document.getElementById("assetCategory_table_info");
            var paginateDiv = document.getElementById("assetCategory_table_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "assetCategory_table_length" div and its select element
            var existingDiv = document.getElementById("assetCategory_table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }

            // Open modal to edit Asset Category
            AssetCategoryEditModal();
        };

        // Add New Asset
        function AssetCategoryAddButton() {
            $.ajax({
                type: 'POST',
                url: "{{ route('assetCategory.create') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    name: document.getElementById("AssetCategoryAddName").value,
                    code: document.getElementById("AssetCategoryAddCode").value,
                    description: document.getElementById("AssetCategoryAddDescription").value,
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#AssetCategoryAddModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("AssetCategoryAddName").value = "";
                    document.getElementById("AssetCategoryAddCode").value = "";
                    document.getElementById("AssetCategoryAddDescription").value = "";

                    // Reload table
                    $('#assetCategory_table').DataTable().ajax.reload();
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

        // Open modal to edit asset Category
        function AssetCategoryEditModal() {
            // Remove previous click event listeners
            $(document).off('click', "[id^='assetCategory_table'] tbody tr td:not(:last-child)");

            $(document).on('click', "[id^='assetCategory_table'] tbody tr td:not(:last-child)", function() {
                // Place values to edit form fields in the modal
                document.getElementById("AssetCategoryEditCode").value = $(event.target).closest('tr').find('td:nth-child(' + '1' + ')').text();
                document.getElementById("AssetCategoryEditName").value = $(event.target).closest('tr').find('td:nth-child(' + '2' + ')').text();
                document.getElementById("AssetCategoryEditDescription").value = $(event.target).closest('tr').find('td:nth-child(' + '3' + ')').text();


                // Grab row Asset Category id
                originalAssetCategoryId = $(event.target).closest('tr').find('td:nth-child(6) a').attr('id').split('-')[1];

                // Open modal
                var element = "#AssetCategoryEditModal";
                openAltEditorModal(element);
            });
        }

        // Edit Asset Category
        function editAssetCategory() {
            
            var code = document.getElementById("AssetCategoryEditCode").value;
            var name = document.getElementById("AssetCategoryEditName").value;
            var description = document.getElementById("AssetCategoryEditDescription").value;

            $.ajax({
                type: 'POST',
                url: "{{ route('assetCategory.edit') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    name: name,
                    code: code,
                    description: description,
                    original_asset_category_id: originalAssetCategoryId
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#AssetCategoryEditModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("AssetCategoryEditCode").value = "";
                    document.getElementById("AssetCategoryEditName").value = "";
                    document.getElementById("AssetCategoryEditDescription").value = "";


                    // Reload table
                    $('#assetCategory_table').DataTable().ajax.reload();
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

        // Delete Asset Category
        function AssetCategoryDeleteButton() {
            var deleteAssetCategoryId = lastClickedLink.split("-")[1];

            $.ajax({
                type: 'POST',
                url: "{{ route('assetCategory.delete') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    delete_assetCategory_id: deleteAssetCategoryId
                },
                success: function (response) {
                    // Close modal after successfully deleted
                    var element = "#AssetCategoryDeleteModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully deleted.", "#91C714");

                    // Reload table
                    $('#assetCategory_table').DataTable().ajax.reload();
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