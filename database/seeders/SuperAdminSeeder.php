<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Check if the admin with the username 'superadmin' already exists
        $superAdmin = User::where('username', 'superadmin')->first();

        if (is_null($superAdmin)) {
            // Create the 'superadmin' user
            $superAdmin = new User();
            $superAdmin->name = "Super Admin";
            $superAdmin->email = "superadmin@bluedale.com.my";
            $superAdmin->username = "superadmin";
            $superAdmin->password = Hash::make('password');
            $superAdmin->save();
        }

        // Check if the user 'admin' already exists
        $admin = User::where('username', 'admin')->first();

        if (is_null($admin)) {
            // Create the 'admin' user
            $admin = new User();
            $admin->name = "Admin";
            $admin->email = "admin@bluedale.com.my";
            $admin->username = "admin";
            $admin->password = Hash::make('password');
            $admin->save();
        }

        // Check if the user 'supports' already exists
        $supports = User::where('username', 'supports')->first();

        if (is_null($supports)) {
            // Create the 'supports' user
            $supports = new User();
            $supports->name = "Supports";
            $supports->email = "supports@bluedale.com.my";
            $supports->username = "supports";
            $supports->password = Hash::make('password');
            $supports->save();
        }

        // Check if the user 'sales' already exists
        $sales = User::where('username', 'sales')->first();

        if (is_null($sales)) {
            // Create the 'sales' user
            $sales = new User();
            $sales->name = "Sales";
            $sales->email = "sales@bluedale.com.my";
            $sales->username = "sales";
            $sales->password = Hash::make('password');
            $sales->save();
        }

        // Check if the user 'services' already exists
        $services = User::where('username', 'services')->first();

        if (is_null($services)) {
            // Create the 'services' user
            $services = new User();
            $services->name = "Services";
            $services->email = "services@bluedale.com.my";
            $services->username = "services";
            $services->password = Hash::make('password');
            $services->save();
        }
    }
}