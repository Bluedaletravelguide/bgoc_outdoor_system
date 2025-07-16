@extends('layouts.main')

@section('title')
<title>Chulia Middle East - Building</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto"> Locations </h2>
    <!-- BEGIN: Add New Building -->
    <div class="text-center">
        <a href="javascript:;" data-toggle="modal" data-target="#buildingAddModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add New Building
        </a>
    </div>
    <!-- END: Add New Building -->
</div>

@if($errors->any())
<div class="intro-y box p-5 mt-5">
    <div class="mb-5 p-5 rounded-md" style="background-color:#fdecf1;">
        <h2 class="text-lg font-medium">
            Errors:
        </h2>

        @foreach ($errors->all() as $error)
        <p class="w-12 flex-none xl:w-auto xl:flex-initial ml-2">{{ $error }}</p>
        @endforeach
    </div>
</div>
@endif

@if(session('error'))
<div class="intro-y box p-5 mt-5">
    <div class="mb-5 p-5 rounded-md" style="background-color:#fdecf1;">
        <h2 class="text-lg font-medium">
            Errors:
        </h2>

        <p class="w-12 flex-none xl:w-auto xl:flex-initial ml-2">{{ session('error') }}</p>
    </div>
</div>
@endif

@if(session('success'))
<div class="intro-y box p-5 mt-5">
    <div class="mb-5 p-5 rounded-md" style="background-color:#ecfdef;">
        <p class="w-12 flex-none xl:w-auto xl:flex-initial ml-2">{{ session('success') }}</p>
    </div>
</div>
@endif

<div class="intro-y chat grid grid-cols-12 gap-5 mt-5">
    <!-- BEGIN: Buildings List Side Menu -->
    <div class="col-span-12 lg:col-span-4 xxl:col-span-3">
        <div class="intro-y pr-1">
            <div class="box p-2">
                <div class="chat__tabs nav-tabs justify-center flex">
                    <a data-toggle="tab" data-target="#new" href="javascript:;" class="flex-1 py-2 rounded-md text-center active">Buildings List</a>
                </div>
            </div>
        </div>
        <div class="tab-content">

            <div class="tab-content__pane active" id="new">
                <div class="pr-1">
                    <div class="box p-5 mt-5">
                        <div class="relative text-gray-700 dark:text-gray-300">
                            <input type="text" id="searchNewPatientInput" class="input input--lg w-full bg-gray-200 pr-10 placeholder-theme-13" placeholder="Search for buildings">
                            <i class="w-4 h-4 sm:absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>
                        </div>
                    </div>
                </div>

                <div class="chat__user-list overflow-y-auto scrollbar-hidden pr-1 pt-1" id="newPatientList">

                    @foreach($locations as $alphabet => $locationsGroup)
                    <div class="mt-4 text-gray-600">{{ $alphabet }}</div>
                    @foreach($locationsGroup as $location)
                    <div class="cursor-pointer box relative flex items-center p-5 mt-5 zoom-in" id="building-{{ $location->id }}">
                        <div class="ml-2 overflow-hidden">
                            <div class="flex items-center">
                                <a href="" class="font-medium">{{ $location->name }}</a>
                            </div>
                        </div>
                        <div class="dropdown ml-auto">
                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"> <i data-feather="more-horizontal" class="w-5 h-5 text-gray-600 dark:text-gray-300"></i> </a>
                            <div class="dropdown-box w-40">
                                <div class="dropdown-box__content box dark:bg-dark-1 p-2">
                                    <a href="javascript:;" data-toggle="modal" data-target="#buildingEditModal" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md buildingEditModalButton">
                                        <i data-feather="edit" class="w-4 h-4 mr-2"></i>
                                        Edit Building
                                    </a>
                                    <a href="javascript:;" data-toggle="modal" data-target="#buildingDeleteModal" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md buildingDeleteModalButton">
                                        <i data-feather="trash" class="w-4 h-4 mr-2"></i>
                                        Delete Building
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endforeach

                </div>

            </div>

        </div>
    </div>
    <!-- END: Buildings List Side Menu -->

    <!-- BEGIN: Buildings List Profile -->
    <div class="intro-y col-span-12 lg:col-span-8 xxl:col-span-9">
        <!-- BEGIN: New Buildings List Profile -->
        <div class="h-full flex flex-col intro-y box px-5" id="defaultProfile">
            <div class="flex flex-col sm:flex-row border-b border-gray-200 dark:border-dark-5 py-4">
                <div class="flex items-center">
                    <h1 class="text-xl text-theme-1 font-medium leading-none">
                        <span class="px-4 py-2 bg-theme-1 text-white rounded-md"><span id="buildingName"></span></span>
                    </h1>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row border-b border-gray-200 dark:border-dark-5 pb-5 -mx-5">
                <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                    <div class="ml-5">
                        <h1 class="text-xl text-theme-1 font-medium leading-none mb-3 text-center">

                        </h1>
                        <div class="font-medium text-lg"><span id="buildingCompanyName"></span></div>
                    </div>
                </div>

                <div class="mt-6 lg:mt-0 flex-1 dark:text-gray-300 px-5 border-l border-r border-gray-200 dark:border-dark-5 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="pocket" class="w-4 h-4 mr-2"></i> Contract: <span id="buildingContract"></span></div>
                    </div>
                </div>
            </div>

            <div class="intro-y tab-content mt-5">
                <!-- BEGIN: Add New Level -->
                <div class="text-center">
                    <a href="javascript:;" data-toggle="modal" data-target="#levelAddModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white levelAddModalButton">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add New Level
                    </a>
                </div>
                <!-- END: Add New Level -->

                <div class="overflow-x-auto scrollbar-hidden">
                    <table class="table table-report table mt-5" id="table">
                        <thead>
                            <tr class="bg-theme-32 text-white">
                                <th>Level</th>
                                <th>Departments</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END: New Buildings List Profile -->
    </div>
    <!-- END: Buildings List Profile -->
</div>
@endsection('app_content')

@section('modal_content')
<!-- BEGIN: Building Add Modal -->
<div class="modal" id="buildingAddModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Add Building</h2>
        </div>
        <form action="{{ route('locations.building.store') }}" method="POST">
            @csrf
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Building Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Building Name" name="addBuildingName" id="addBuildingName" autocomplete="off" required>
                </div>
            </div>

            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Client Company</label>
                    <select data-search="true" class="tail-select w-full border mt-2 flex-1" name="addClientCompanyInput" id="addClientCompanyInput" required>
                        @foreach($clientCompanies as $clientCompany)
                        <option value="{{ $clientCompany->id }}">{{ $clientCompany->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="sub-category">
                <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12" id="addLevelsContainer">
                        <label>Level(s)</label>
                        <div class="flex items-center mt-2">
                            <input type="text" class="input w-full border flex-1" placeholder="Level Name" name="addLevelInput[]" required autocomplete="off">
                            <a href="javascript:void(0);" class="button bg-theme-1 text-white ml-2" onclick="removeLevelField(this)">
                                Remove
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="button" onclick="addLevelField()" class="button w-30 bg-theme-1 text-white">Add Level</button>
                <button type="submit" class="button w-20 bg-theme-1 text-white">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Building Add Modal -->

<!-- BEGIN: Building Edit Modal -->
<div class="modal" id="buildingEditModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Edit Building</h2>
        </div>
        <form action="{{ route('locations.building.update') }}" method="POST">
            @csrf
            <input type="text" class="hidden" name="editBuildingId" id="editBuildingId">

            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Building Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Building Name" name="editBuildingName" id="editBuildingName" autocomplete="off" required>
                </div>
            </div>
            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Building Edit Modal -->

<!-- BEGIN: Building Delete Modal -->
<div class="modal" id="buildingDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm deleting the building? This process cannot be undone.</div>
        </div>

        <form action="{{ route('locations.building.delete') }}" method="POST">
            @csrf
            <input type="text" class="hidden" name="deleteBuildingId" id="deleteBuildingId">

            <div class="px-5 pb-8 text-center">
                <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
                <button type="submit" class="button w-24 bg-theme-6 text-white">Delete</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Building Delete Modal -->



<!-- BEGIN: Level Add Modal -->
<div class="modal" id="levelAddModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Add Level</h2>
        </div>
        <form action="{{ route('locations.level.store') }}" method="POST">
            @csrf
            <input type="text" class="hidden" name="addLevelBuildingId" id="addLevelBuildingId">

            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Level Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Level Name" name="addLevelName" id="addLevelName" autocomplete="off" required>
                </div>
            </div>

            <div class="sub-category">
                <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12" id="addDepartmentsContainer">
                        <label>Department(s)</label>
                        <div class="flex items-center mt-2">
                            <input type="text" class="input w-full border flex-1" placeholder="Level Name" name="addDepartmentInput[]" required autocomplete="off">
                            <a href="javascript:void(0);" class="button bg-theme-1 text-white ml-2" onclick="removeDepartmentField(this)">
                                Remove
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="button" onclick="addDepartmentField()" class="button w-30 bg-theme-1 text-white">Add Level</button>
                <button type="submit" class="button w-20 bg-theme-1 text-white">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Level Add Modal -->

<!-- BEGIN: Level Edit Modal -->
<div class="modal" id="levelEditModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Edit Level</h2>
        </div>
        <form action="{{ route('locations.level.update') }}" method="POST">
            @csrf
            <input type="text" class="hidden" name="editLevelId" id="editLevelId">

            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Level Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Level Name" name="editLevelName" id="editLevelName" autocomplete="off" required>
                </div>
            </div>

            <div class="sub-category">
                <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <label>Department Name</label>
                        <div id="editDepartmentsContainer">

                        </div>
                    </div>
                </div>
            </div>

            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="button" onclick="editDepartmentField()" class="button w-20 bg-theme-1 text-white">Add</button>
                <button type="submit" class="button w-20 bg-theme-1 text-white levelEditModalButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Level Edit Modal -->

<!-- BEGIN: Level Delete Modal -->
<div class="modal" id="levelDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm deleting the level? This process cannot be undone.</div>
        </div>

        <form action="{{ route('locations.level.delete') }}" method="POST">
            @csrf
            <input type="text" class="hidden" name="deleteLevelId" id="deleteLevelId">

            <div class="px-5 pb-8 text-center">
                <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
                <button type="submit" class="button w-24 bg-theme-6 text-white levelDeleteModalButton">Delete</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Level Delete Modal -->



<!-- BEGIN: Department Delete Modal -->
<div class="modal" id="departmentDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm deleting the department? This process cannot be undone.</div>
        </div>

        <form action="{{ route('locations.department.delete') }}" method="POST">
            @csrf
        <input type="text" class="hidden" name="deleteDepartmentId" id="deleteDepartmentId">

        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="submit" class="button w-24 bg-theme-6 text-white departmentDeleteModalButton">Delete</button>
        </div>
        </form>
    </div>
</div>
<!-- END: Department Delete Modal -->
@endsection('modal_content')

@section('script')
<script>
    var buildingId = @json($firstBuildingId);
    var deleteLevelId;
    var editLevelId;

    function getBuildingDetails() {
        $.ajax({
            type: 'POST',
            url: "{{ route('locations.building.details') }}",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                building_id: buildingId
            },
            success: function(response) {
                document.getElementById("buildingName").innerHTML = response.data.building_name;
                document.getElementById("buildingCompanyName").innerHTML = response.data.client_company_name;
                document.getElementById("buildingContract").innerHTML = response.data.contract_prefix;
            }
        });
    }

    function getDeleteLevelId(id) {
        deleteLevelId = id;
    }

    function getEditLevelId(id) {
        editLevelId = id;
        editLevelButton();
    }

    function getDeleteDepartmentId(id) {
        deleteDepartmentId = id;
    }

    function editLevelButton() {
        // Remove previous click event listeners
        $(document).off('click', "[id^='table'] tbody tr td");

        $(document).on('click', "[id^='table'] tbody tr td", function() {
            // Place values to edit form fields in the modal
            document.getElementById("editLevelName").value = $(event.target).closest('tr').find('td:nth-child(' + '1' + ')').text();

            // Remove any existing floor input fields
            $("#editDepartmentsContainer").empty();
            var listItemValues = [];
            $(event.target).closest('tr').find('li').each(function() {
                var editDepartmentId = $(this).attr('id').split('-')[2];
                var editDepartmentName = $(this).text();

                var levelDepartmentInputTemplate =
                    `
                    <div class="flex items-center mt-2">
                        <input type="text" class="input w-full border flex-1" placeholder="Department Name" value="${editDepartmentName}" name="editExistingDepartmentNameInput[]" required autocomplete="off">
                        <a href="javascript:;" data-toggle="modal" data-target="#departmentDeleteModal" class="button bg-theme-6 text-white ml-2" onclick="getDeleteDepartmentId(${editDepartmentId})">
                            Delete
                        </a>
                        <input type="hidden" name="editExistingDepartmentIdInput[]" value="${editDepartmentId}">
                    </div>
                `;

                $("#editDepartmentsContainer").append(levelDepartmentInputTemplate);
            });
        });
    }

    $(document).ready(function() {
        // Edit building fields placeholder
        var buildingEditModalButtons = document.querySelectorAll('.buildingEditModalButton');
        var buildingDeleteModalButtons = document.querySelectorAll('.buildingDeleteModalButton');
        var levelAddModalButtons = document.querySelectorAll('.levelAddModalButton');
        var levelDeleteModalButtons = document.querySelectorAll('.levelDeleteModalButton');
        var levelEditModalButtons = document.querySelectorAll('.levelEditModalButton');
        var departmentDeleteModalButtons = document.querySelectorAll('.departmentDeleteModalButton');

        // Iterate over the NodeList and add an event listener to each element
        buildingEditModalButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                document.getElementById("editBuildingName").value = document.getElementById("buildingName").innerHTML;
                document.getElementById("editBuildingId").value = buildingId;
            });
        });

        buildingDeleteModalButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                document.getElementById("deleteBuildingId").value = buildingId;
            });
        });

        levelAddModalButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                document.getElementById("addLevelBuildingId").value = buildingId;
            });
        });

        levelEditModalButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                document.getElementById("editLevelId").value = editLevelId;
            });
        });

        levelDeleteModalButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                document.getElementById("deleteLevelId").value = deleteLevelId;
            });
        });

        departmentDeleteModalButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                document.getElementById("deleteDepartmentId").value = deleteDepartmentId;
            });
        });  
    });
</script>

<script>
    $(document).ready(function() {
        // Setup the datatable
        function initDatatable() {
            const dt = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName = `Buildings${formattedDate}_${formattedTime}`;

            const table = $('#table').DataTable({
                destroy: true,
                debug: true,
                processing: true,
                searching: true,
                serverSide: true,
                ordering: true,
                order: [
                    [0, 'asc']
                ],
                pagingType: 'full_numbers',
                pageLength: 25,
                aLengthMenu: [
                    [25, 50, 75, -1],
                    [25, 50, 75, "All"]
                ],
                iDisplayLength: 25,
                ajax: {
                    url: "{{ route('locations.building.list') }}",
                    dataType: "json",
                    type: "POST",
                    data: function(d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        d.building_id = buildingId;
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
                        data: "parent_location_name",
                    },
                    {
                        data: "location_details",
                        render: function(data, type, row) {
                            const branchList = (data[0] && data[0].name !== null) ?
                                data.map(item => `<li class="cursor-pointer text-xs list-disc mb-1" id="department-id-${item.id}">${item.name}</li>`).join('') :
                                '';

                            return branchList;
                        }
                    },
                    {
                        data: "level_id",
                        render: function(data, type, row) {
                            button = `  <a href="javascript:;" class="button w-24 inline-block mr-2 mb-2 bg-theme-32 text-white" data-toggle="modal" data-target="#levelEditModal" onclick="getEditLevelId(${data});">
                                            Edit
                                        </a>
                                        <a href="javascript:;" class="button w-24 inline-block mr-2 mb-2 bg-theme-6 text-white" data-toggle="modal" data-target="#levelDeleteModal" onclick="getDeleteLevelId(${data});">
                                            Delete
                                        </a>`;

                            return button;
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
            var filterDiv = document.getElementById("table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv = document.getElementById("table_info");
            var paginateDiv = document.getElementById("table_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "table_length" div and its select element
            var existingDiv = document.getElementById("table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }
        };

        initDatatable();
        getBuildingDetails();


        /** Click to view new patient profile **/
        const clickNewPatientList = document.getElementById('newPatientList');
        const clickableNewPatientElements = clickNewPatientList.querySelectorAll('.cursor-pointer');

        clickableNewPatientElements.forEach(element => {
            element.addEventListener('click', function(event) {
                buildingId = element.id.split('-')[1];

                // Prevent default link behavior
                event.preventDefault();

                getBuildingDetails();
                initDatatable();
            });
        });


        /** Search function for new patient list **/
        const searchNewPatientInput = document.getElementById('searchNewPatientInput');
        const newPatientList = document.getElementById('newPatientList');

        searchNewPatientInput.addEventListener('input', function(event) {
            const searchQuery = event.target.value.trim().toLowerCase();
            const patients = newPatientList.querySelectorAll('.cursor-pointer');

            patients.forEach(function(patient) {
                const patientName = patient.querySelector('.font-medium').textContent.toLowerCase();

                if (patientName.includes(searchQuery)) {
                    patient.classList.remove('hidden');
                } else {
                    patient.classList.add('hidden');
                }
            });
        });
    });
</script>

<script>
    // Add a new level input field in add modal
    function addLevelField() {
        var levelInputTemplate = `
            <div class="flex items-center mt-2">
                <input type="text" class="input w-full border flex-1" placeholder="Level Name" name="addLevelInput[]" required autocomplete="off">
                <a href="javascript:void(0);" class="button bg-theme-1 text-white ml-2" onclick="removeLevelField(this)">
                    Remove
                </a>
            </div>
        `;

        $("#addLevelsContainer").append(levelInputTemplate);
    }

    function addDepartmentField() {
        var departmentInputTemplate = `
            <div class="flex items-center mt-2">
                <input type="text" class="input w-full border flex-1" placeholder="Level Name" name="addDepartmentInput[]" required autocomplete="off">
                <a href="javascript:void(0);" class="button bg-theme-1 text-white ml-2" onclick="removeDepartmentField(this)">
                    Remove
                </a>
            </div>
        `;

        $("#addDepartmentsContainer").append(departmentInputTemplate);
    }

    // Add a new department input field in edit modal
    function editDepartmentField() {
        var floorInputTemplate = `
            <div class="flex items-center mt-2">
                <input type="text" class="input w-full border flex-1" placeholder="Department Name" name="editNewDepartmentNameInput[]" required autocomplete="off">
                <a href="javascript:void(0);" class="button bg-theme-1 text-white ml-2" onclick="removeDepartmentField(this)">
                    Remove
                </a>
            </div>
        `;

        $("#editDepartmentsContainer").append(floorInputTemplate);
    }

    // Remove a level input field in add & edit modal
    function removeLevelField(button) {
        $(button).closest('.flex').remove();
    }

    function removeDepartmentField(button) {
        $(button).closest('.flex').remove();
    }
</script>
@endsection('script')