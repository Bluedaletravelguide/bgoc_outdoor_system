@extends('layouts.main')

@section('title')
<title>Chulia Middle East - On-Site</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            On-Site
        </h2>
    </div>

    <!-- BEGIN: Tabs -->
    <div class="intro-y pr-1">
        <div class="box p-2">
            <div class="pos__tabs nav-tabs justify-center flex">
                <a data-toggle="tab" data-target="#onsite-teams" href="javascript:;" class="flex-1 py-2 rounded-md text-center active">OnSite Teams</a>
                <a data-toggle="tab" data-target="#onsite-members" href="javascript:;" class="flex-1 py-2 rounded-md text-center">OnSite Members</a>
            </div>
        </div>
    </div>
    <!-- END: Tabs -->

    <div class="tab-content">

        <!-- BEGIN: onsite-teamMembers -->
        <div class="tab-content__pane mt-4" id="onsite-members">
            <!-- Table Filter -->
            <!-- <div class="flex flex-col sm:flex-row sm:items-end xl:items-start mb-2 mt-2">
                <div class="text-center">
                    <a href="javascript:;" data-toggle="modal" data-target="#basic-modal-create" class="button inline-block bg-theme-1 text-white">
                        +Add New Member
                    </a> 
                </div>
            </div> -->
            <!-- Filter End -->

            <div class="intro-y box p-5 mt-5">
                <div class="flex flex-col sm:flex-row sm:items-end xl:items-start mb-2 mt-2">
                    <div class="text-center">
                        <a href="javascript:;" data-toggle="modal" data-target="#Member-modal-create" class="button inline-block bg-theme-1 text-white">
                            +Add New Member
                        </a> 
                    </div>
                </div>
                <!-- Members table -->
                <div class="overflow-x-auto scrollbar-hidden">
                    <table class="table table-report mt-5" id="onsite_member_table">
                        <thead>
                            <tr class="bg-theme-1 text-white">
                                <th class="whitespace-nowrap">OnSite-Team</th>
                                <th class="whitespace-nowrap">Employee Name</th>
                                <th class="whitespace-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <!-- Table End -->
            </div>
        </div>
        <!-- END: onsite-teamMembers -->

        <!-- BEGIN: onsite-teams -->
        <div class="tab-content__pane mt-4 active" id="onsite-teams">
            <!-- Table Filter -->
            <!-- <div class="flex flex-col sm:flex-row sm:items-end xl:items-start mb-2 mt-2">
                <div class="text-center">
                    <a href="javascript:;" data-toggle="modal" data-target="#basic-modal-create" class="button inline-block bg-theme-1 text-white">
                        +Add New Member
                    </a> 
                </div>
            </div> -->
            <!-- Filter End -->

            <div class="intro-y box p-5 mt-5">
                <div class="flex flex-col sm:flex-row sm:items-end xl:items-start mb-2 mt-2">
                    <div class="text-center">
                        <a href="javascript:;" data-toggle="modal" data-target="#Team-modal-create" class="button inline-block bg-theme-1 text-white">
                            +Add New Team
                        </a> 
                    </div>
                </div>
                <!-- Teams table -->
                <div class="overflow-x-auto scrollbar-hidden">
                    <table class="table table-report mt-5" id="onsite_team_table">
                        <thead>
                            <tr class="bg-theme-1 text-white">
                                <th class="whitespace-nowrap" width="20%">Team Name</th>
                                <th class="whitespace-nowrap" width="20%">Contract id</th>
                                <th class="whitespace-nowrap" width="20%">Type</th>
                                <th class="whitespace-nowrap" width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <!-- Table End -->
            </div>
        </div>
        <!-- END: onsite-teams -->
    </div>

    <!-- Create Teams Modal -->
    <div class="modal" id="Team-modal-create"> 
        <div class="modal__content"> 
            <h2 class="font-medium text-base mr-auto p-2">
                Create New Team
            </h2>
            <!-- BEGIN: Form Layout Create -->
            <div class="intro-y box p-2">
                <form action="{{ route('onSite.teams.create') }}" method="POST">
                @csrf
                    <label>Team Name</label>
                    <div class="form-group">
                        <input type="text" id="team_name" name="team_name" class="input w-full border mt-2" placeholder="Input Name">
                    </div>
                    <div class="mt-3 form-group">
                        <label>Contract</label>
                        <div class="mt-2">
                            <select data-placeholder="Select Contract" id="contract_id" name="contract_id" class="tail-select w-full">
                                <option value="">-- Select Contract --</option>
                                @foreach ($Contract as $cont)
                                    @if ($cont->team_name === null)
                                        <option value="{{ $cont->id }}">{{ $cont->contract_prefix }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-3 form-group">
                        <label>Type</label>
                        <div class="mt-2">
                            <select data-placeholder="Select Type" id="type" name="type" class="tail-select w-full">
                                <option value="">-- Select Type --</option>
                                <option value="In-house">In-House Teams</option>
                                <option value="Mobile">Mobile Teams</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-right mt-5 p-4">
                        <button type="button" data-dismiss="modal" class="button w-24 border dark:border-dark-5 text-gray-700 dark:text-gray-300 mr-1">Cancel</button>
                        <button type="submit" class="button w-24 bg-theme-1 text-white">Save</button>
                    </div>
                </form>
            </div>
            <!-- END: Form Layout -->
        </div> 
    </div> 
    <!-- END: Create modal -->
    <!-- Create memberModal -->
    <div class="modal" id="Member-modal-create"> 
        <div class="modal__content"> 
            <h2 class="font-medium text-base mr-auto p-2">
                Create New Members List
            </h2>
            <!-- BEGIN: Form Layout Create -->
            <div class="intro-y box p-2">
                <form action="{{ route('onSite.members.create') }}" method="POST">
                @csrf
                    <label>Team Name</label>
                        <div class="mt-2 form-group">
                            <select data-placeholder="Select Team" id="onsite_team_id" name="onsite_team_id" class="tail-select w-full">
                                <option value="">-- Select Team --</option>
                                @foreach ($Teamlist as $group)
                                    @if($group->onsite_team === null)
                                        <option value="{{ $group->id }}">{{ $group->onsite_team_id }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    <div class="mt-3 form-group">
                        <label>Members</label>
                        <div class="mt-2">
                            @foreach ($Members as $member)
                                @if($member->employee_id === null)
                                    <div class="flex items-center mt-2">
                                        <input type="checkbox" name="employee_id[]" id="employee_id{{ $member->id }}" value="{{ $member->id }}" class="form-checkbox">
                                        <label for="employee_id{{ $member->id }}" class="ml-2">{{ $member->name }}</label>
                                    </div>
                                @endif
                            @endforeach
                            <!-- <select data-placeholder="Select Team" id="employee_id" name="employee_id" class="tail-select w-full">
                                <option value="">-- Select Members --</option>
                                @foreach ($Employee as $member)
                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </select> -->
                        </div>
                    </div>
                    <div class="text-right mt-5 p-4">
                        <button type="button" data-dismiss="modal" class="button w-24 border dark:border-dark-5 text-gray-700 dark:text-gray-300 mr-1">Cancel</button>
                        <button type="submit" class="button w-24 bg-theme-1 text-white">Save</button>
                    </div>
                </form>
            </div>
            <!-- END: Form Layout -->
        </div> 
    </div> 
    <!-- END: Create membermodal -->

    @foreach ($Teams as $Teams)
        <form id="delete-teams-{{ $Teams->id }}" action="{{ route('onSite.teams.destroy',$Teams->id) }}" method="POST">
            @method('DELETE')
            @csrf
            <!-- Delete Modal -->
            <div class="modal" id="DeleteTeam-{{ $Teams->id }}">
                <div class="modal__content">
                    <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-gray-600 mt-2">Confirm deleting On-site Team?</div>
                        <div class="text-gray-600 mt-2">Deleting Team will also remove employees from team members list.</div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
                        <button class="button w-24 mr-2 mb-2 items-center justify-center bg-theme-6 text-white"
                            onclick="event.preventDefault(); document.getElementById('delete-teams-{{ $Teams->id }}').submit();"> 
                                Delete 
                        </button> 
                    </div>
                </div>
            </div>
            <!-- END Delete Modal -->
        </form>
        <!-- Edit teamsModal -->
        <a href="javascript:;" data-toggle="modal" data-target="#teams-modal-edit-{{ $Teams->id }}"
            class="hidden w-24 mr-2 mb-2 bg-theme-12 text-white">
            Edit
        </a> 
        <div class="modal rounded-sm" id="teams-modal-edit-{{ $Teams->id }}"> 
            <div class="modal__content p-2"> 
                <h2 class="text-lg font-medium p-2">
                    Edit Employee Details
                </h2>
                <!-- BEGIN: Form Layout Edit -->
                <div class="intro-y box p-2">
                    <form id="update-form-{{ $Teams->id }}" action="{{ route('onSite.teams.update',$Teams->id) }}" method="POST">
                    @csrf
                    <label>Team Name</label>
                        <div class="form-group">
                            <input type="text" id="team_name" name="team_name" class="input w-full border mt-2" value="{{ $Teams->team_name }}">
                        </div>
                        <div class="mt-3 form-group">
                            <label>Contract</label>
                            <div class="mt-2">
                                <select data-placeholder="Select User ID" id="contract_id" name="contract_id"  class="tail-select w-full">
                                    <option value="">-- Select Contract --</option>
                                    @foreach ($Contract as $item)
                                        <option value="{{$item->id}}"{{ $item->id == $Teams->contract_id ? 'selected':'' }}>{{ $item->contract_prefix }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-3 form-group">
                            <label>Type</label>
                            <div class="mt-2">
                                <select data-placeholder="Select Type" id="type" name="type" class="tail-select w-full">
                                    <option value="">-- Select Type --</option>
                                    <option value="In-house"{{ $Teams->type == 'In-house' ? 'selected':'' }}>In-House Teams</option>
                                    <option value="Mobile"{{ $Teams->type == 'Mobile' ? 'selected':'' }}>Mobile Teams</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-right mt-5 p-4">
                            <button type="button" data-dismiss="modal" class="button w-24 border dark:border-dark-5 text-gray-700 dark:text-gray-300 mr-1">Cancel</button>
                            <button type="submit" class="button w-24 bg-theme-1 text-white">Save</button>
                        </div>
                    </form>
                </div>
                <!-- END: Form Layout -->
            </div> 
        </div> 
        <!-- Modal End -->

    <!-- Edit memberModal -->
    <div class="modal" id="basic-modal-edit-{{ $Teams->id }}"> 
        <div class="modal__content"> 
            <h2 class="font-medium text-base mr-auto p-2">
                Create New Members List
            </h2>
            <!-- BEGIN: Form Layout Create -->
            <div class="intro-y box p-2">
                <form action="{{ route('onSite.members.update',$Teams->id) }}" method="POST">
                @csrf
                    <label>Team Name</label>
                        <div class="mt-2 form-group">
                            <select data-placeholder="Select Team" id="onsite_team_id" name="onsite_team_id" class="tail-select w-full" readonly>
                                    <option value="{{ $Teams->id }}">{{ $Teams->team_name }}</option>
                            </select>
                            <div class="form-group">
                        </div>
                        </div>
                    <div class="mt-3 form-group">
                        <label>Members</label>
                        <div class="mt-2">
                            @foreach ($Employee as $member)
                                <div class="flex items-center mt-2">
                                    <input type="checkbox" name="employee_id[]" id="employee_id{{ $member->id }}" value="{{ $member->id }}" class="form-checkbox" {{ $member->onsite_team_id == $Teams->id ? "checked" : "" }}>
                                    <label for="employee_id{{ $member->id }}" class="ml-2">{{ $member->name }}</label>
                                </div>
                            @endforeach
                            <!-- <select data-placeholder="Select Team" id="employee_id" name="employee_id" class="tail-select w-full">
                                <option value="">-- Select Members --</option>
                                @foreach ($Employee as $member)
                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </select> -->
                        </div>
                    </div>
                    <div class="text-right mt-5 p-4">
                        <button type="button" data-dismiss="modal" class="button w-24 border dark:border-dark-5 text-gray-700 dark:text-gray-300 mr-1">Cancel</button>
                        <button type="submit" class="button w-24 bg-theme-1 text-white">Save</button>
                    </div>
                </form>
            </div>
            <!-- END: Form Layout -->
        </div> 
    </div> 
    <!-- END: Edit membermodal -->


    @endforeach

@endsection('app_content')

@section('script')
<script>
    	
    $(document).ready(function() {

        // When page first loads, load the data table
        membersDatatable();
        teamsDatatable();

        // Setup the teams datatable
        function teamsDatatable() {
            const dt = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName = `Employee_List_${formattedDate}_${formattedTime}`;

            const table = $('#onsite_team_table').DataTable({
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
                    url: "{{ route('onSite.teams.list') }}",
                    dataType: "json",
                    type: "POST",
                    data: function(d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        return d;
                    },
                    dataSrc: function(json) {
                        json.recordsTotal = json.recordsTotal;
                        json.recordsFiltered = json.recordsFiltered;
                        return json.data;
                    }
                },
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
                            stripHtml: false,
                        },
                        init: function(api, node, config) {
                            $(node).removeClass('dt-button');
                            $(node).removeClass('buttons-html5');
                        },
                    },
                ],
                dom: "lBfrtip",
                columns: [{
                        data: "team_name",
                    },
                    {
                        data: "contract_id",
                    },
                    {
                        data: "type",
                    },
                    {
                        data: "id",
                        render: function(data, type, row) {
                            let id = data;
                            let element = `<div class="flex flex-row">
                            <a href="javascript:;" data-toggle="modal" data-target="#teams-modal-edit-`+id+`"
                                class="button w-24 inline-block mr-2 mb-2 bg-theme-12 text-white">
                                Edit
                            </a>
                            <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#DeleteTeam-`+id+`">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 w-4 h-4 mr-1">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg> 
                            </a>
                            </div>`;
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
            var filterDiv = document.getElementById("members_data_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv = document.getElementById("members_data_table_info");
            var paginateDiv = document.getElementById("members_data_table_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "inhouse_users_table_length" div and its select element
            var existingDiv = document.getElementById("members_data_table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }
        };

        // Setup the members datatable
        function membersDatatable() {
            const dt = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName = `Employee_List_${formattedDate}_${formattedTime}`;

            const table = $('#onsite_member_table').DataTable({
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
                    url: "{{ route('onSite.members.list') }}",
                    dataType: "json",
                    type: "POST",
                    data: function(d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        return d;
                    },
                    dataSrc: function(json) {
                        json.recordsTotal = json.recordsTotal;
                        json.recordsFiltered = json.recordsFiltered;
                        return json.data;
                    }
                },
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
                            stripHtml: false,
                        },
                        init: function(api, node, config) {
                            $(node).removeClass('dt-button');
                            $(node).removeClass('buttons-html5');
                        },
                    },
                ],
                dom: "lBfrtip",
                columns: [
                    {
                        data: "onsite_team_id",
                    },
                    {
                        data: "employee_id",
                        render: function (data, type, row) {
                            if (Array.isArray(data) && data.length > 0) {
                                let memberList = data.map(member => {
                                    return `<li class="cursor-pointer list-disc">${member}</li>`;
                                });

                                return `<ul class="pl-4">${memberList.join('')}</ul>`;
                            } else {
                                return ''; // Return an empty string if there are no sub_categories
                            }
                        }
                    },
                    {
                        data: "id",
                        render: function(data, type, row) {
                            let id = data;
                            let element = `<div class="flex flex-row">
                            <a href="javascript:;" data-toggle="modal" data-target="#basic-modal-edit-`+id+`"
                                class="button w-24 inline-block mr-2 mb-2 bg-theme-12 text-white">
                                Edit
                            </a>
                            </div>`;
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
            var filterDiv = document.getElementById("members_data_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv = document.getElementById("members_data_table_info");
            var paginateDiv = document.getElementById("members_data_table_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "inhouse_users_table_length" div and its select element
            var existingDiv = document.getElementById("members_data_table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }
        };

    })
</script>
@endsection('script')