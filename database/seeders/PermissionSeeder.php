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
         * 6. client_company            [C|R|U|D]
         * 7. billboard                 [C|R|U|D]
         * 8. billboard_booking         [C|R|U|D]
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
                'group_name' => 'client_company',
                'permissions' => [
                    // client Company Permissions
                    'client_company.create',
                    'client_company.view',
                    'client_company.edit',
                    'client_company.delete',
                ]
            ],
            [
                'group_name' => 'billboard',
                'permissions' => [
                    // billboard Permissions
                    'billboard.create',
                    'billboard.view',
                    'billboard.edit',
                    'billboard.delete',
                ]
            ],
            [
                'group_name' => 'billboard_booking',
                'permissions' => [
                    // billboard booking Permissions
                    'billboard_booking.create',
                    'billboard_booking.view',
                    'billboard_booking.edit',
                    'billboard_booking.delete',
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
        $superAdmin = User::where('username', 'superadmin')->first();
        if ($superAdmin) {
            $superAdmin->assignRole($roleSuperAdmin);
        }



        // Create a new role for "admin"
        $roleAdmin = Role::create(['name' => 'admin', 'guard_name' => 'web']);

        $admin = User::where('username', 'admin')->first();
        if ($admin) {
            $admin->assignRole($roleAdmin);
        }

        /**
         * just a line to separate 
         * 
        */
        // Define the permissions for the "admin" role
        $permissionsAdminWeb = [
            'profile.view',
            'profile.edit',
            'client.view',
            'client.edit',
            'client_company.view',
            'client_company.edit',
            'billboard_booking.create',
            'billboard_booking.view',
            'billboard_booking.edit',
            'billboard_booking.delete',
            'dashboard.view',
            'dashboard.edit',
        ];

        foreach ($permissionsAdminWeb as $adminPermission) {
            // Create the permission if it doesn't exist
            Permission::firstOrCreate(['name' => $adminPermission]);

            // Assign the permission to the "coo" role
            $roleAdmin->givePermissionTo($adminPermission);
        }

        /**
         * just a line to separate 
         * 
        */

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Create a new role for "sales"
        $roleSales = Role::create(['name' => 'sales', 'guard_name' => 'web']);

        $sales = User::where('username', 'sales')->first();
        if ($sales) {
            $sales->assignRole($roleSales);
        }

        // Define the permissions for the "sales" role
        $permissionsSalesWeb = [
            'user.view',
            'user.edit',
            'profile.view',
            'profile.edit',
            'client.view',
            'billboard_booking.create',
            'billboard_booking.view',
            'billboard_booking.edit',
            'billboard_booking.delete',
            'billboard.create',
            'billboard.view',
            'billboard.edit',
            'billboard.delete',
            'dashboard.view',
            'dashboard.edit',
        ];

        foreach ($permissionsSalesWeb as $salesPermission) {
        //     // Create the permission if it doesn't exist
            Permission::firstOrCreate(['name' => $salesPermission]);

        //     // Assign the permission to the "sales" role
            $roleSales->givePermissionTo($salesPermission);
        }

        /**
         * just a line to separate 
         * 
        */

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        
        // Create a new role for "marketing"
        $roleMarketing = Role::create(['name' => 'marketing', 'guard_name' => 'web']);
        // $role_marketing_api = Role::create(['name' => 'marketing', 'guard_name' => 'api']);

        $marketings = User::where('username', 'like', '%marketing%')->get();
        if ($marketings) {
            foreach ($marketings as $marketingPermission) {
                $marketingPermission->assignRole($roleMarketing);
            }
        }

        // Define the permissions for the "marketing" role
        $permissionsMarketingWeb = [
            'profile.view',
            'profile.edit',
            'billboard.view',
            'billboard.edit',
            'billboard_booking.view',
            'billboard_booking.edit',
            'dashboard.view',
            'dashboard.edit',
        ];

        foreach ($permissionsMarketingWeb as $marketingPermission) {
            // Create the permission if it doesn't exist
            Permission::firstOrCreate(['name' => $marketingPermission]);

            // Assign the permission to the "marketing" role
            $roleMarketing->givePermissionTo($marketingPermission);
        }
    }
}