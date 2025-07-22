<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // List all the roles
        $roles = [
            'superadmin',
            'admin',
            'sales',
            'marketing',
        ];

        // Insert the roles to "roles" table
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // List all the usernames
        $usernames = [
            'superadmin',
            'admin',
            'sales',
            'marketing',
        ];

        // To create user accounts
        foreach ($usernames as $username) {
            $user = User::where('username', $username)->first();
            $role = Role::where('name', $username)->first();

            $this->command->info($role);

            // If the user does not exist, create them
            if (is_null($user)) {
                $user = new User();
                $user->name = ucwords(str_replace('_', ' ', $username)); // Convert underscores to spaces and capitalize words
                $user->email = $username . "@bluedale.com.my";
                $user->username = $username;
                $user->status = 1;
                $user->password = Hash::make('password');

                $user->save();

                // Assign the role to the user
                $user->assignRole($role);
            }
        }

        // Assign all permissions to Super Admin role
        $role_superadmin = Role::where('name', 'Superadmin')->get();
        $permissions_superadmin = Permission::pluck('id', 'id')->all();
        $role_superadmin[0]->syncPermissions($permissions_superadmin);
    }
}
