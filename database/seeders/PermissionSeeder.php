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
         * 1. dashboard                 [R|U]
         * 2. billboard master          [C|R|U|D]
         * 3. monthy ongoing            [C|R|U|D]
         * 4. billboard availability    [C|R|U|D]
         * 5. users                     [C|R|U|D]
         * 6. role                      [C|R|U|D]
         * 7. profile                   [R|U]
         * 8. clients                   [C|R|U|D]
         * 9. contractors               [C|R|U|D]
         * 10. stock invenrtory         [C|R|U|D]
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
                'group_name' => 'billboard',
                'permissions' => [
                    // billboard master Permissions
                    'billboard.create',
                    'billboard.view',
                    'billboard.edit',
                    'billboard.delete',
                ]
            ],
            [
                'group_name' => 'monthly_ongoing',
                'permissions' => [
                    // monthy ongoing Permissions
                    'monthly_ongoing.create',
                    'monthly_ongoing.view',
                    'monthly_ongoing.edit',
                    'monthly_ongoing.delete',
                ]
            ],
            [
                'group_name' => 'billboard_availability',
                'permissions' => [
                    // billboard availability Permissions
                    'billboard_availability.create',
                    'billboard_availability.view',
                    'billboard_availability.edit',
                    'billboard_availability.delete',
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
                'group_name' => 'contractor',
                'permissions' => [
                    // contractor Permissions
                    'contractor.create',
                    'contractor.view',
                    'contractor.edit',
                    'contractor.delete',
                ]
            ],
            [
                'group_name' => 'stock_inventory',
                'permissions' => [
                    // stock inventory Permissions
                    'stock_inventory.create',
                    'stock_inventory.view',
                    'stock_inventory.edit',
                    'stock_inventory.delete',
                ]
            ],
        ];

        // --- Create all permissions once ---
        foreach ($permissions as $group) {
            foreach ($group['permissions'] as $perm) {
                Permission::firstOrCreate(
                    ['name' => $perm, 'guard_name' => 'web'],
                    ['group_name' => $group['group_name']]
                );
            }
        }

        /**
         * super admin role
         * 
        */

        // --- Super Admin role (all permissions) ---
        $roleSuperAdmin = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $roleSuperAdmin->givePermissionTo(Permission::all());

        if ($superAdmin = User::where('username', 'superadmin')->first()) {
            $superAdmin->assignRole($roleSuperAdmin);
        }

        // --- Admin role (subset of permissions) ---
        $roleAdmin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        $adminPermissions = Permission::whereNotIn('name', [
            // Exclude permissions you don’t want admin to have
            'role.create',
            'role.edit',
            'role.delete',
            'user.delete',
        ])->get();

        $roleAdmin->syncPermissions($adminPermissions);

        if ($admin = User::where('username', 'admin')->first()) {
            $admin->assignRole($roleAdmin);
        }

        // Reset cache
        app()['cache']->forget('spatie.permission.cache');

        /**
         * sales role
         * 
        */

        // Create a new role for "sales"
        $roleSales = Role::create(['name' => 'sales', 'guard_name' => 'web']);

        $sales = User::where('username', 'sales')->first();
        if ($sales) {
            $sales->assignRole($roleSales);
        }

        // Define the permissions for the "sales" role
        $permissionsSalesWeb = [
            'dashboard.view',
            'dashboard.edit',
            'profile.view',
            'profile.edit',
            'client.view',
            'monthly_ongoing.create',
            'monthly_ongoing.view',
            'monthly_ongoing.edit',
            'monthly_ongoing.delete',
            'billboard_availability.create',
            'billboard_availability.view',
            'billboard_availability.edit',
            'billboard_availability.delete',
            'billboard.view',
        ];

        foreach ($permissionsSalesWeb as $salesPermission) {
        //     // Create the permission if it doesn't exist
            Permission::firstOrCreate(['name' => $salesPermission]);

        //     // Assign the permission to the "sales" role
            $roleSales->givePermissionTo($salesPermission);
        }

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        /**
         * sales role
         * 
        */

        /**
         * services role
         * 
        */

        // Create a new role for "services"
        $roleServices = Role::create(['name' => 'services', 'guard_name' => 'web']);
        // $role_marketing_api = Role::create(['name' => 'marketing', 'guard_name' => 'api']);

        $services = User::where('username', 'like', '%services%')->get();
        if ($services) {
            foreach ($services as $servicesPermission) {
                $servicesPermission->assignRole($roleServices);
            }
        }

        // Define the permissions for the "services" role
        $permissionsServicesWeb = [
            'dashboard.view',
            'dashboard.edit',
            'profile.view',
            'profile.edit',
            'client.view',
            'monthly_ongoing.create',
            'monthly_ongoing.view',
            'monthly_ongoing.edit',
            'monthly_ongoing.delete',
            'billboard_availability.create',
            'billboard_availability.view',
            'billboard_availability.edit',
            'billboard_availability.delete',
            'billboard.view',
        ];

        foreach ($permissionsServicesWeb as $servicesPermission) {
            // Create the permission if it doesn't exist
            Permission::firstOrCreate(['name' => $servicesPermission]);

            // Assign the permission to the "services" role
            $roleServices->givePermissionTo($servicesPermission);
        }

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        /**
         * services role
         * 
        */

        /**
         * supports role
         * 
        */

        // Create a new role for "supports"
        $roleSupports = Role::create(['name' => 'supports', 'guard_name' => 'web']);
        // $role_marketing_api = Role::create(['name' => 'marketing', 'guard_name' => 'api']);

        $supports = User::where('username', 'like', '%supports%')->get();
        if ($supports) {
            foreach ($supports as $supportsPermission) {
                $supportsPermission->assignRole($roleSupports);
            }
        }

        // Define the permissions for the "supports" role
        $permissionsSupportsWeb = [
            'dashboard.view',
            'dashboard.edit',
            'profile.view',
            'profile.edit',
            'billboard.create',
            'billboard.view',
            'billboard.edit',
            'billboard.delete',
            'billboard_booking.view',
            'billboard_availability.view',
        ];

        foreach ($permissionsSupportsWeb as $supportsPermission) {
            // Create the permission if it doesn't exist
            Permission::firstOrCreate(['name' => $supportsPermission]);

            // Assign the permission to the "supports" role
            $roleSupports->givePermissionTo($supportsPermission);
        }

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        /**
         * supports role
         * 
        */
    }
}