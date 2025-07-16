@extends('layouts.main')

@section('title')
<title>Chulia Middle East - Asset</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Assets
    </h2>
</div>

<div class="intro-y box p-5 mt-5">
    <div class="pos col-span-12 lg:col-span-4">
        <!-- BEGIN: Asset -->
        <div>
            <!-- BEGIN: Filter & Add Asset -->
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
                        <button type="button" class="button w-full sm:w-16 bg-theme-32 text-white" id="filterAssetButton">Filter</button>
                    </div>
                </form>
                <!-- END: Filter -->

                <!-- BEGIN: Add Asset -->
                <div class="text-center">
                    <a href="javascript:;" data-toggle="modal" data-target="#AssetsAddModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add New Asset
                    </a>
                </div>
                <!-- END: Add Asset -->
            </div>
            <!-- END: Filter & Add Asset -->

            <!-- BEGIN: Asset List -->
            <div class="overflow-x-auto scrollbar-hidden">
                <table class="table table-report mt-5" id="assets_table">
                    <thead>
                        <tr class="bg-theme-32 text-white">
                            <th>Asset Code</th>
                            <th>Asset Name</th>
                            <th>Asset Category</th>
                            <th>Description</th>
                            <th>Asset Location</th>
                            <th>Purchase Order Receipt Reference ID</th>
                            <th class="dt-exclude-export dt-no-sort ">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- END: Asset List -->
        </div>
        <!-- END: Asset -->
    </div>
</div>
@endsection('app_content')

@section('modal_content')
<!-- BEGIN: Asset Add Modal -->
<div class="modal" id="AssetsAddModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Add Asset</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Asset Code</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Asset Code" id="AssetsAddCode" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Asset Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Asset Name" id="AssetsAddName" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Asset Category</label>
                    <!-- Building Dropdown -->
                    <select class="input w-full border mt-2 flex-1" id="AssetsAddCategory" required>
                        <option selected disabled value>Select an Asset Category</option>
                        @foreach ($assetsCategory as $assetCat)
                            <option value="{{ $assetCat->id }}"> {{ $assetCat->code }} - {{ $assetCat->name }} </option>
                        @endforeach
                       
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Description</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Description" id="AssetsAddDesc" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Location</label>
                    <!-- Building Dropdown -->
                    <select class="input w-full border mt-2 flex-1" id="AssetsAddBuilding" required>
                        <option selected disabled value>Building - Select a Building</option>
                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}"> {{ $building->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <!-- Level Dropdown -->
                    <select class="input w-full border mt-2 flex-1" id="AssetsAddLevel" style="display: none;" required>
                        <option selected disabled value>Level - Select a Level</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}"> {{ $level->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <!-- Building Dropdown -->
                    <select class="input w-full border mt-2 flex-1" id="AssetsAddDept" style="display: none;" required>
                        <option selected disabled value>Department - Select a Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}"> {{ $department->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Purchase Order Receipt Reference ID</label>
                    <!-- Building Dropdown -->
                    <select class="input w-full border mt-2 flex-1" id="AssetsAddPORRID" required>
                        <option selected disabled value>Select Purchase Order</option>
                        @foreach ($purchaseOrder as $purchaseOrd)
                            <option value="{{ $purchaseOrd->id }}"> {{ $purchaseOrd->receipt_reference_number }} - {{ $purchaseOrd->description }} </option>
                        @endforeach
                    </select>
                </div>
            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="AssetsAddButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Asset Add Modal -->

<!-- BEGIN: Asset Edit Modal -->
<div class="modal" id="AssetsEditModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Edit Asset</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Asset Code</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Asset Code" id="AssetsEditCode" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Asset Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Asset Name" id="AssetsEditName" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Asset Category</label>
                    <!-- Building Dropdown -->
                    <select class="input w-full border mt-2 flex-1" placeholder="Type" id="AssetsEditCategory" required>
                        <!-- <option selected disabled value>Select an Asset Category</option> -->
                        <!-- Add your options dynamically here -->
                        @foreach ($assetsCategory as $assetCat)
                            <option value="{{ $assetCat->id }}"> {{ $assetCat->code }} - {{ $assetCat->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Description</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Description" id="AssetsEditDesc" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Location</label>
                    <!-- Building Dropdown -->
                    <select class="input w-full border mt-2 flex-1" id="AssetsEditBuilding" required>
                        <option selected disabled value>Building - Select a Building</option>
                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}"> {{ $building->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <!-- Level Dropdown -->
                    <select class="input w-full border mt-2 flex-1" id="AssetsEditLevel" required>
                        <option selected disabled value>Level - Select a Level</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}"> {{ $level->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <!-- Building Dropdown -->
                    <select class="input w-full border mt-2 flex-1" id="AssetsEditDept" required>
                        <option selected disabled value>Department - Select a Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}"> {{ $department->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Purchase Order Receipt Reference ID</label>
                    <!-- Building Dropdown -->
                    <select class="input w-full border mt-2 flex-1" id="AssetsEditPORRID" required>
                        <option selected disabled value>Select Purchase Order</option>
                        @foreach ($purchaseOrder as $purchaseOrd)
                            <option value="{{ $purchaseOrd->id }}"> {{ $purchaseOrd->receipt_reference_number }} - {{ $purchaseOrd->description }} </option>
                        @endforeach
                    </select>
                </div>
            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="AssetsEditButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Asset Edit Modal -->

<!-- BEGIN: Asset Delete Modal -->
<div class="modal" id="AssetsDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm deleting this asset? This process cannot be undone.</div>
        </div>
        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="AssetsDeleteButton">Delete</button>
        </div>
    </div>
</div>
<!-- END: Asset Delete Modal -->
@endsection('modal_content')

@section('script')
<script>
    $(document).ready(function() {
        // When building select input changes
        $('#AssetsAddBuilding').change(function () {
            var buildingId = $(this).val();

            // console.log(buildingId);
            if (buildingId) {
                // Make AJAX request to fetch levels for selected building
                $.get('/get-levels', { building_id: buildingId }, function (data) {
                    $('#AssetsAddLevel').empty();
                    $('#AssetsAddDept').empty();
                    $('#AssetsAddLevel').show(); // Show level select input
                    $('#AssetsAddDept').hide(); // Show level select input
                    $('#AssetsAddLevel').append('<option value="">Select Level</option>');
                    $.each(data, function (index, level) {
                        $('#AssetsAddLevel').append('<option value="' + level.id + '">' + level.name + '</option>');
                    });
                });
            } else {
                // Hide level and department select inputs if building is not selected
                $('#AssetsAddLevel').hide();
                $('#AssetsAddDept').hide();
            }
        });

        // When level select input changes
        $('#AssetsAddLevel').change(function () {
            var levelId = $(this).val();

            // console.log(levelId);

            if (levelId) {
                // Make AJAX request to fetch departments for selected level
                $.get('/get-departments', { level_id: levelId }, function (data) {
                    $('#AssetsAddDept').empty();
                    $('#AssetsAddDept').show(); // Show department select input
                    $('#AssetsAddDept').append('<option value="">Select Department</option>');
                    $.each(data, function (index, department) {
                        $('#AssetsAddDept').append('<option value="' + department.id + '">' + department.name + '</option>');
                    });
                });
            } else {
                // Hide department select input if level is not selected
                $('#AssetsAddDept').hide();
            }
        });

        // Close modal
        function getLocation() {
            
            // When building select input changes
            $('#AssetsEditBuilding').change(function () {
                var buildingId = $(this).val();

                // console.log(buildingId);
                if (buildingId) {
                    // Make AJAX request to fetch levels for selected building
                    $.get('/get-levels', { building_id: buildingId }, function (data) {
                        
                        $('#AssetsEditLevel').empty();
                        $('#AssetsEditDept').empty();
                        $('#AssetsEditLevel').show(); 
                        $('#AssetsEditDept').hide();// Show level select input
                        $('#AssetsEditLevel').append('<option value="">Select Level</option>');
                        $('#AssetsEditDept').append('<option value="">Select Department</option>');
                        $.each(data, function (index, level) {
                            $('#AssetsEditLevel').append('<option value="' + level.id + '">' + level.name + '</option>');
                        });
                    });
                } else {
                    // Hide level and department select inputs if building is not selected
                    $('#AssetsEditLevel').hide();
                    $('#AssetsEditDept').hide();
                }
            });

            // When level select input changes
            $('#AssetsEditLevel').change(function () {
                var levelId = $(this).val();

                // console.log(levelId);

                if (levelId) {
                    // Make AJAX request to fetch departments for selected level
                    $.get('/get-departments', { level_id: levelId }, function (data) {

                        var dept = document.getElementById("AssetsEditDept").value;

                        $('#AssetsEditDept').empty();
                        $('#AssetsEditDept').show(); // Show department select input
                        $('#AssetsEditDept').append('<option value="">Select Department</option>');
                        $.each(data, function (index, department) {
                            $('#AssetsEditDept').append('<option value="' + department.id + '">' + department.name + '</option>');
                        });
                    });
                } else {
                    // Hide department select input if level is not selected
                    $('#AssetsEditDept').hide();
                }
            });
        }
    
        // Global variables
        // var filterUserAccountStatus;
        var filterAssetCategory;
        var originalAssetsId;
        var lastClickedLink;
        let table;

        // Listen to below buttons
        document.getElementById("filterAssetButton").addEventListener("click", filterAssetButton);
        document.getElementById("AssetsAddButton").addEventListener("click", AssetsAddButton);
        document.getElementById("AssetsDeleteButton").addEventListener("click", AssetsDeleteButton);

        // When "filterAssetButton" button is clicked, initiate initAssetsDatatable
        function filterAssetButton() {
            // filterUserAccountStatus = document.getElementById("inputUserAccountStatus").value;
            filterAssetCategory = document.getElementById("inputAssetCategory").value;
            initAssetsDatatable(filterAssetCategory);
        };

        // When page first loads, load table
        filterAssetButton();

        // When any submit button is clicked
        (function() {
            var assets_table = $('#assets_table')[0].altEditor;

            document.getElementById('AssetsAddButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();
            });

            document.getElementById('AssetsEditButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Edit filterAssetCategory
                editAssets();
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

        // Setup the Asset datatable
        function initAssetsDatatable() {
            const dt = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName = `Assets_List_${formattedDate}_${formattedTime}`;

            const table = $('#assets_table').DataTable({
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
                    url: "{{ route('assets.list') }}",
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
                    // targets:6, // Index of the "Purchase Order ID" column
                    // visible: false, // Hide the column
                    // data: "purchase_order_id" // Include data attribute for selecting/accessing the value
                }],
                columns: [{
                        data: "code",
                    },
                    {
                        data: "name",
                    },
                    {
                        data: "asset_category",
                        render: function(data, type, row) {
                            let element = `
                            <a class="flex items-center " id="${row.asset_category_id}">`+ data +`</a>`;

                            return element;
                        }
                    },
                    {
                        data: "description",
                    },
                    {
                        data: "location_name",
                        render: function(data, type, row) {
                            let element = `
                            <a class="flex items-center " id="${row.location_id}">`+ data +`</a>`;

                            return element;
                        }
                    },
                    {
                        data: "receipt_reference_number",
                        render: function(data, type, row) {
                            let element = `
                            <a class="flex items-center " id="${row.purchase_order_id}">`+ data +`</a>`;

                            return element;
                        }
                    },
                    {
                        data: "id",
                        render: function(data, type, row) {
                            let element = `
                            <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#AssetsDeleteModal" id="delete-` + data + `">
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
            var filterDiv = document.getElementById("assets_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv = document.getElementById("assets_table_info");
            var paginateDiv = document.getElementById("assets_table_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "assets_table_length" div and its select element
            var existingDiv = document.getElementById("assets_table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }

            // Open modal to edit Asset
            AssetsEditModal();
        };

        // Add New Asset
        function AssetsAddButton() {
            $.ajax({
                type: 'POST',
                url: "{{ route('assets.create') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    code: document.getElementById("AssetsAddCode").value,
                    name: document.getElementById("AssetsAddName").value,
                    asset_category_id: document.getElementById("AssetsAddCategory").value,
                    desc: document.getElementById("AssetsAddDesc").value,
                    dept: document.getElementById("AssetsAddDept").value,
                    purchase_order_id: document.getElementById("AssetsAddPORRID").value,
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#AssetsAddModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("AssetsAddCode").value = "";
                    document.getElementById("AssetsAddName").value = "";
                    document.getElementById("AssetsAddCategory").value = "";
                    document.getElementById("AssetsAddDesc").value = "";
                    document.getElementById("AssetsAddBuilding").value = "";
                    document.getElementById("AssetsAddLevel").value = "";
                    document.getElementById("AssetsAddDept").value = "";
                    document.getElementById("AssetsAddPORRID").value = "";

                    // Reload table
                    $('#assets_table').DataTable().ajax.reload();
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

        // Open modal to edit assets
        function AssetsEditModal() {
            
            // Remove previous click event listeners
            $(document).off('click', "[id^='assets_table'] tbody tr td:not(:last-child)");

            $(document).on('click', "[id^='assets_table'] tbody tr td:not(:last-child)", function() {
                // Place values to edit form fields in the modal
                document.getElementById("AssetsEditCode").value = $(event.target).closest('tr').find('td:nth-child(' + '1' + ')').text();
                document.getElementById("AssetsEditName").value = $(event.target).closest('tr').find('td:nth-child(' + '2' + ')').text();
                document.getElementById("AssetsEditCategory").value = $(event.target).closest('tr').find('td:nth-child(' + '3' + ')').find('a').attr('id');
                document.getElementById("AssetsEditDesc").value = $(event.target).closest('tr').find('td:nth-child(' + '4' + ')').text();
                document.getElementById("AssetsEditBuilding").value = $(event.target).closest('tr').find('td:nth-child(' + '5' + ')').find('a').attr('id');
                document.getElementById("AssetsEditPORRID").value = $(event.target).closest('tr').find('td:nth-child(' + '6' + ')').find('a').attr('id');

                var dept_id = $(event.target).closest('tr').find('td:nth-child(' + '5' + ')').find('a').attr('id');

                console.log(dept_id);

                // Grab row Asset id
                originalAssetsId = $(event.target).closest('tr').find('td:nth-child(7) a').attr('id').split('-')[1];

                // // Make AJAX request to fetch departments for selected level
                $.get('/get-location', { dept_id: dept_id }, function (data) {

                    $('#AssetsEditDept').empty();
                    $('#AssetsEditDept').show(); // Show department select input
                    $.each(data.departments, function (index, dept) {
                        console.log(dept.name);
                        if (dept.id == dept_id) {
                            level_id = dept.parent_id;
                            $('#AssetsEditDept').append('<option selected value="' + dept.id + '">' + dept.name + '</option>');
                            console.log(level_id);
                        }else{
                            $('#AssetsEditDept').append('<option value="' + dept.id + '">' + dept.name + '</option>');
                        }
                    });

                    $('#AssetsEditLevel').empty();
                    $('#AssetsEditLevel').show(); // Show department select input
                    $.each(data.levels, function (index, lvl) {
                        // console.log(dept.name);
                        if (lvl.id == level_id) {
                            building_id = lvl.parent_id;
                            $('#AssetsEditLevel').append('<option selected value="' + lvl.id + '">' + lvl.name + '</option>');
                        }else{
                            // console.log(level_id);
                            $('#AssetsEditLevel').append('<option value="' + lvl.id + '">' + lvl.name + '</option>');
                        }
                    });

                    $('#AssetsEditBuilding').empty();
                    $('#AssetsEditBuilding').show(); // Show department select input
                    $.each(data.buildings, function (index, bldg) {
                        // console.log(dept.name);
                        if (bldg.id == building_id) {
                            building_id = bldg.parent_id;
                            $('#AssetsEditBuilding').append('<option selected value="' + bldg.id + '">' + bldg.name + '</option>');
                        }else{
                            // console.log(level_id);
                            $('#AssetsEditBuilding').append('<option value="' + bldg.id + '">' + bldg.name + '</option>');
                        }
                    });
                    
                    

                    getLocation();
                });

                // Open modal
                var element = "#AssetsEditModal";
                openAltEditorModal(element);
            });
        }
        // Edit Asset
        function editAssets() {
            var code = document.getElementById("AssetsEditCode").value;
            var name = document.getElementById("AssetsEditName").value;
            var asset_category_id = document.getElementById("AssetsEditCategory").value;
            var desc = document.getElementById("AssetsEditDesc").value;
            var building = document.getElementById("AssetsEditBuilding").value;
            var level = document.getElementById("AssetsEditLevel").value;
            var dept = document.getElementById("AssetsEditDept").value;
            var purchase_order_id = document.getElementById("AssetsEditPORRID").value;

            $.ajax({
                type: 'POST',
                url: "{{ route('assets.edit') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    code: code,
                    name: name,
                    asset_category_id: asset_category_id,
                    desc: desc,
                    building: building,
                    level: level,
                    dept: dept,
                    purchase_order_id: purchase_order_id,
                    original_asset_id: originalAssetsId
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#AssetsEditModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("AssetsEditCode").value = "";
                    document.getElementById("AssetsEditName").value = "";
                    document.getElementById("AssetsEditCategory").value = "";
                    document.getElementById("AssetsEditDesc").value = "";
                    document.getElementById("AssetsEditBuilding").value = "";
                    document.getElementById("AssetsEditLevel").value = "";
                    document.getElementById("AssetsEditDept").value = "";
                    document.getElementById("AssetsEditPORRID").value = "";

                    // Reload table
                    $('#assets_table').DataTable().ajax.reload();
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

        // Delete Asset
        function AssetsDeleteButton() {
            var deleteAssetId = lastClickedLink.split("-")[1];

            // Log the deleteAssetId to check its value
                console.log("deleteAssetId:", deleteAssetId);

            $.ajax({
                type: 'POST',
                url: "{{ route('assets.delete') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    delete_asset_id: deleteAssetId
                },
                success: function (response) {
                    // Close modal after successfully deleted
                    var element = "#AssetsDeleteModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully deleted.", "#91C714");

                    // Reload table
                    $('#assets_table').DataTable().ajax.reload();
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