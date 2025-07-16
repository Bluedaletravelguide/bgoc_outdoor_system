<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permission List as array
        /**
         * Permission groups
         * 1. dashboard                 [U|R]
         * 2. user                      [C|R|U|D]
         * 3. role                      [C|R|U|D]
         * 4. profile                   [R|U]
         * 5. client                    [C|R|U|D]
         * 6. work_order                [C|R|U|D]
         * 7. service_request           [C|R|U|D]
         * 8. service_request_category  [C|R|U|D]
         * 9. employee                  [C|R|U|D]
         * 10. onsite                   [C|R|U|D]
         * 11. vendor                   [C|R|U|D]
         * 12. project                 [C|R|U|D]
         */
        $permissions = [

            [
                'group_name' => 'dashboard',
                'permissions' => [
                    'dashboard.view',
                    'dashboard.edit',
                ]
            ],
            [
                'group_name' => 'user',
                'permissions' => [
                    // admin Permissions
                    'user.create',
                    'user.view',
                    'user.edit',
                    'user.delete',
                ]
            ],
            [
                'group_name' => 'role',
                'permissions' => [
                    // role Permissions
                    'role.create',
                    'role.view',
                    'role.edit',
                    'role.delete',
                ]
            ],
            [
                'group_name' => 'profile',
                'permissions' => [
                    // profile Permissions
                    'profile.view',
                    'profile.edit',
                ]
            ],
            [
                'group_name' => 'client',
                'permissions' => [
                    // client Permissions
                    'client.create',
                    'client.view',
                    'client.edit',
                    'client.delete',
                ]
            ],
            [
                'group_name' => 'work_order',
                'permissions' => [
                    // work order Permissions
                    'work_order.create',
                    'work_order.view',
                    'work_order.edit',
                    'work_order.delete',
                ]
            ],
            [
                'group_name' => 'service_request',
                'permissions' => [
                    // service request Permissions
                    'service_request.create',
                    'service_request.view',
                    'service_request.edit',
                    'service_request.delete',
                ]
            ],
            [
                'group_name' => 'service_request_category',
                'permissions' => [
                    // service request category Permissions
                    'service_request_category.create',
                    'service_request_category.view',
                    'service_request_category.edit',
                    'service_request_category.delete',
                ]
            ],
            [
                'group_name' => 'employee',
                'permissions' => [
                    // employee Permissions
                    'employee.create',
                    'employee.view',
                    'employee.edit',
                    'employee.delete',
                ]
            ],
            [
                'group_name' => 'onsite',
                'permissions' => [
                    // onsite Permissions
                    'onsite.create',
                    'onsite.view',
                    'onsite.edit',
                    'onsite.delete',
                ]
            ],
            [
                'group_name' => 'vendor',
                'permissions' => [
                    // vendor Permissions
                    'vendor.create',
                    'vendor.view',
                    'vendor.edit',
                    'vendor.delete',
                ]
            ],
            [
                'group_name' => 'project',
                'permissions' => [
                    // project Permissions
                    'project.create',
                    'project.view',
                    'project.edit',
                    'project.delete',
                ]
            ],
            [
                'group_name' => 'asset',
                'permissions' => [
                    // asset Permissions
                    'asset.create',
                    'asset.view',
                    'asset.edit',
                    'asset.delete',
                ]
            ],
            [
                'group_name' => 'supplier',
                'permissions' => [
                    // suppliers Permissions
                    'suppliers.create',
                    'suppliers.view',
                    'suppliers.edit',
                    'suppliers.delete',
                ]
            ],
        ];

        $roleSuperAdmin = Role::create(['name' => 'superadmin', 'guard_name' => 'web']);

        // Create and Assign Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create Permission
                $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup, 'guard_name' => 'web']);
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
            }
        }

        // Assign super admin role permission to superadmin user
        $admin = User::where('username', 'superadmin')->first();
        if ($admin) {
            $admin->assignRole($roleSuperAdmin);
        }

        // Create a new role for "client_user"
        $role_client_user_web = Role::create(['name' => 'client_user', 'guard_name' => 'web']);

        $admin = User::where('username', 'client_user')->first();
        if ($admin) {
            $admin->assignRole($role_client_user_web);
            // $admin->assignRole($role_client_user_api);
        }

        /**
         * just a line to separate 
         * 
        */
        // Define the permissions for the "client_user" role
        $permissionsClientUserWeb = [
            'profile.view',
            'profile.edit',
            'client.view',
            'client.edit',
            'service_request.create',
            'service_request.view',
            'service_request.edit',
            'service_request.delete',
            // 'work_order.create',
            // 'work_order.view',
            // 'work_order.delete',
            'dashboard.view',
            'dashboard.edit',
        ];

        foreach ($permissionsClientUserWeb as $permissionsClientUserWeb) {
            // Create the permission if it doesn't exist
            Permission::firstOrCreate(['name' => $permissionsClientUserWeb]);

            // Assign the permission to the "coo" role
            $role_client_user_web->givePermissionTo($permissionsClientUserWeb);
        }

        /**
         * just a line to separate 
         * 
        */

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Create a new role for "team_leader"
        $role_team_leader_web = Role::create(['name' => 'team_leader', 'guard_name' => 'web']);

        $admin = User::where('username', 'team_leader')->first();
        if ($admin) {
            $admin->assignRole($role_team_leader_web);
        }

        // Define the permissions for the "team_leader" role
        $permissionsTeamLeaderWeb = [
            'user.create',
            'user.view',
            'user.edit',
            'profile.view',
            'profile.edit',
            'client.create',
            'client.view',
            'service_request.create',
            'service_request.view',
            'service_request.edit',
            'service_request.delete',
            // 'service_request_category.view',
            'work_order.view',
            'dashboard.view',
            'dashboard.edit',
        ];

        foreach ($permissionsTeamLeaderWeb as $permissionsTeamLeaderWeb) {
        //     // Create the permission if it doesn't exist
            Permission::firstOrCreate(['name' => $permissionsTeamLeaderWeb]);

        //     // Assign the permission to the "team_leader" role
            $role_team_leader_web->givePermissionTo($permissionsTeamLeaderWeb);
        }

        /**
         * just a line to separate 
         * 
        */

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        
        // Create a new role for "employee_technician"
        $role_employee_technician_web = Role::create(['name' => 'employee_technician', 'guard_name' => 'web']);
        // $role_employee_technician_api = Role::create(['name' => 'employee_technician', 'guard_name' => 'api']);

        $employee_technicians = User::where('username', 'like', '%technician%')->get();
        if ($employee_technicians) {
            foreach ($employee_technicians as $technician) {
                $technician->assignRole($role_employee_technician_web);
            }
        }

        // Define the permissions for the "employee_technician" role
        $permissionsEmployeeTechnicianWeb = [
            // 'user.create',
            // 'user.view',
            // 'user.edit',
            'profile.view',
            'profile.edit',
            'work_order.view',
            'work_order.edit',
            'dashboard.view',
            'dashboard.edit',
        ];

        foreach ($permissionsEmployeeTechnicianWeb as $permissionsEmployeeTechnicianWeb) {
            // Create the permission if it doesn't exist
            Permission::firstOrCreate(['name' => $permissionsEmployeeTechnicianWeb]);

            // Assign the permission to the "coo" role
            $role_employee_technician_web->givePermissionTo($permissionsEmployeeTechnicianWeb);
        }
    }
}