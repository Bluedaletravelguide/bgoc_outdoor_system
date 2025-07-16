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
            Roles & Permissions
        </h2>
    </div>
    
    <div class="intro-y box p-5 mt-5">
        <div class="row flex flex-col sm:flex-row sm:items-end xl:items-start mb-5">
            <div class="col">
                @if (Auth::guard('web')->user()->can('role.create'))
                <div class="text-center"> 
                    <a href="javascript:;" data-toggle="modal" data-target="#basic-modal-preview" class="button inline-block bg-theme-1 text-white">+ Add New Role</a> 
                </div>
                @endif
                <!-- Modal form for Role Creation -->
                <div class="modal" id="basic-modal-preview">
                    <div class="modal__content p-10 text-left">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Role Name</label>
                            <input type="text" id="name" name="name" placeholder="Enter a Role Name" class="mt-1 p-2 border w-full rounded-md" required>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Permissions</label>
                            <div class="mt-2">
                                <div class="flex items-center">
                                    <input type="checkbox" id="checkPermissionAll" value="1" class="form-checkbox" onchange="toggleCheckboxes(this)">
                                    <label for="checkPermissionAll" class="ml-2">All</label>
                                </div>
                                <hr class="my-2">

                                @php $i = 1; @endphp
                                @foreach ($permission_groups as $group)
                                <div class="flex items-center mt-2">
                                    <input type="checkbox" id="{{ $i }}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)" class="form-checkbox">
                                    <label for="{{ $i }}Management" class="ml-2">{{ $group->name }}</label>
                                </div>

                                <div class="ml-8 role-{{ $i }}-management-checkbox">
                                    @php
                                        $permissions = App\Models\User::getpermissionsByGroupName($group->name);
                                        $j = 1;
                                    @endphp
                                    @foreach ($permissions as $permission)
                                        <div class="flex items-center mt-2">
                                            <input type="checkbox" name="permissions[]" id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}" class="form-checkbox">
                                            <label for="checkPermission{{ $permission->id }}" class="ml-2">{{ $permission->name }}</label>
                                        </div>
                                        @php  $j++; @endphp
                                    @endforeach
                                </div>
                                    @php  $i++; @endphp
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="w-24 px-4 py-2 rounded-full shadow-md mr-1 mb-2 bg-theme-9 text-white">Save Role</button>
                    </form>

                    </div>
                </div>
                <!-- end of modal form for role creation -->
            </div>
        </div>
        <!-- datatable start -->
        <div class="overflow-x-auto scrollbar-hidden">
            <table class="table mt-5" id="table">
                <thead>
                    <tr class="bg-theme-1 text-white">
                        <th class="whitespace-nowrap" width="5%">#</th>
                        <th class="whitespace-nowrap" width="10%">Name</th>
                        <th class="whitespace-nowrap" width="60%">Permissions</th>
                        <th class="whitespace-nowrap" width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                    <tr>
                        <td class="border-b dark:border-dark-5">{{ $loop->index+1 }}</td>
                        <td class="font-bold uppercase border-b dark:border-dark-5">{{ $role->name }}</td>
                        <td class="border-b dark:border-dark-5">
                            @foreach ($role->permissions as $perm)
                                <span class="py-1 px-2 rounded-full text-xs bg-theme-6 text-white font-medium">
                                    {{ $perm->name }}
                                </span>
                            @endforeach
                        </td>
                        <td class="border-b dark:border-dark-5">
                            <div class="flex justify-center items-center">
                                @if (Auth::guard('web')->user()->can('role.edit'))
                                    <a class="flex items-center mr-3 edit-role" href="{{ route('roles.edit', $role->id) }}" data-toggle="modal" data-target="#edit-modal-preview-{{ $role->id }}">
                                        <i data-feather="check-square" class="w-4 h-4 mr-1"></i>Edit
                                    </a>

                                    <div class="modal" id="edit-modal-preview-{{ $role->id }}">
                                        <div class="modal__content p-10 text-left">
                                            <form action="{{ route('roles.update', $role->id) }}" method="POST" class="mt-4">
                                                @method('PUT')
                                                @csrf

                                                <div class="mb-4">
                                                    <label for="name" class="block text-sm font-medium text-gray-700">Role Name</label>
                                                    <input type="text" class="mt-1 p-2 border w-full rounded-md" id="name" value="{{ $role->name }}" name="name" placeholder="Enter a Role Name">
                                                </div>

                                                <div class="mb-4">
                                                    <label for="name" class="block text-sm font-medium text-gray-700">Permissions</label>

                                                    <div class="flex items-center mt-2">
                                                        <input type="checkbox" class="form-checkbox" id="checkPermissionAll" value="1" {{ App\Models\User::roleHasPermissions($role, $all_permissions) ? 'checked' : '' }}>
                                                        <label for="checkPermissionAll" class="ml-2">All</label>
                                                    </div>

                                                    <hr class="my-2">

                                                    @php $i = 1; @endphp
                                                    @foreach ($permission_groups as $group)
                                                        <div class="flex items-center mt-2">
                                                            <div class="form-check">
                                                                <input type="checkbox" id="{{ $i }}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)" class="form-checkbox" {{ App\Models\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                                                <label for="{{ $i }}Management" class="ml-2">{{ $group->name }}</label>
                                                            </div>

                                                            <div class="ml-8 role-{{ $i }}-management-checkbox">
                                                                @php
                                                                    $permissions = App\Models\User::getpermissionsByGroupName($group->name);
                                                                    $permissions = $permissions->where('guard_name', $role->guard_name);
                                                                    $j = 1;
                                                                @endphp

                                                                @foreach ($permissions as $permission)
                                                                    <div class="flex items-center mt-2">
                                                                        <input type="checkbox" name="permissions[]" id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}" class="form-checkbox" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                                        <label for="checkPermission{{ $permission->id }}" class="ml-2">{{ $permission->name }}</label>
                                                                    </div>
                                                                    @php  $j++; @endphp
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        @php  $i++; @endphp
                                                    @endforeach
                                                </div>
                                                <button type="submit" class="w-24 px-7 py-2 rounded-full shadow-md ml-auto bg-theme-9 text-white">Update Role</button>
                                            </form>
                                        </div>
                                    </div>
                                @endif


                                @if (Auth::guard('web')->user()->can('role.delete'))
                                    <a class="flex items-center text-theme-6" href="{{ route('roles.destroy', $role->id) }}"
                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $role->id }}').submit();">
                                    <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                                        Delete
                                    </a>

                                    <form id="delete-form-{{ $role->id }}" action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display: none;">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- end of datatable -->
    </div>
    
@endsection

@section('script')
<script>
    $(document).ready(function() {
        var table = $('#table').DataTable();
    })
</script>

<script>
    $(document).ready(function() {
        var table = $('#table').DataTable({
            "dom": 'rtip'
            "paging":   false,
            "ordering": false,
            "info":     false
        });
    })
</script>

<!-- toggle the button check for creation of roles -->
<script>
    function toggleCheckboxes(checkbox) {
        const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = checkbox.disabled ? checkbox.checked : !checkbox.checked;
        });
    }
</script>
<script>
    function checkPermissionByGroup(groupClass, checkbox) {
        const childCheckboxes = document.querySelectorAll(`.${groupClass} input[name="permissions[]"]`);
        childCheckboxes.forEach(childCheckbox => {
            childCheckbox.checked = checkbox.checked;
        });
    }
</script>

<!-- load the edit modal once -->
<script defer>
    $(document).ready(function () {
        $('.edit-role').click(function (event) {
            event.preventDefault();
            var url = $(this).attr('href');

            // Load the content into the edit modal
            $('#edit-modal-preview-{{ $role->id }} .modal__content').load(url, function () {
                // Open the edit modal after the content is loaded
                $('#edit-modal-preview-{{ $role->id }}').modal('show');
            });
        });
    });
</script>

@endsection('script')