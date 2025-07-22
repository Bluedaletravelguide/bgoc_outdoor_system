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
            // $superAdmin->type = "employee";
            $superAdmin->password = Hash::make('password');
            $superAdmin->save();
        }

        // Check if the user 'admin' already exists
        $admin = User::where('username', 'admin')->first();

        if (is_null($admin)) {
            // Create the 'clientUser' user
            $admin = new User();
            $admin->name = "Admin";
            $admin->email = "admin@bluedale.com.my";
            $admin->username = "admin";
            $admin->password = Hash::make('password');
            $admin->save();
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

        for ($i = 1; $i <= 5; $i++) {
            $username = "marketing" . $i;
            $email = "marketing" . $i . "@bluedale.com.my";
            $name = "Marketing " . $i;
        
            // Check if the 'marketing' user already exists
            $marketing = User::where('username', $username)->first();
        
            if (is_null($marketing)) {
                // Create the user
                $marketing = new User();
                $marketing->name = $name;
                $marketing->email = $email;
                $marketing->username = $username;
                // $marketing->type = "employee";
                $marketing->password = Hash::make('password');
                $marketing->save();
            }
        }

    }
}