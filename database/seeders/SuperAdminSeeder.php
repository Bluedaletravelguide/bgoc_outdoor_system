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
            $superAdmin->email = "superadmin@mmdt.cc";
            $superAdmin->username = "superadmin";
            $superAdmin->type = "employee";
            $superAdmin->password = Hash::make('password');
            $superAdmin->save();
        }

        // Check if the user 'clientUser' already exists
        $clientUser = User::where('username', 'client_user')->first();

        if (is_null($clientUser)) {
            // Create the 'clientUser' user
            $clientUser = new User();
            $clientUser->name = "Client User";
            $clientUser->email = "client_user@mmdt.cc";
            $clientUser->username = "client_user";
            $clientUser->type = "client";
            $clientUser->password = Hash::make('password');
            $clientUser->save();
        }

        // Check if the user 'team_leader' already exists
        $team_leader = User::where('username', 'team_leader')->first();

        if (is_null($team_leader)) {
            // Create the 'team_leader' user
            $team_leader = new User();
            $team_leader->name = "Team Leader";
            $team_leader->email = "team_leader@mmdt.cc";
            $team_leader->username = "team_leader";
            $team_leader->type = "employee";
            $team_leader->password = Hash::make('password');
            $team_leader->save();
        }

        for ($i = 1; $i <= 5; $i++) {
            $username = "employee_technician_" . $i;
            $email = "employee_technician_" . $i . "@mmdt.cc";
            $name = "Employee Technician " . $i;
        
            // Check if the user already exists
            $existingUser = User::where('username', $username)->first();
        
            if (is_null($existingUser)) {
                // Create the user
                $employee_technician = new User();
                $employee_technician->name = $name;
                $employee_technician->email = $email;
                $employee_technician->username = $username;
                $employee_technician->type = "employee";
                $employee_technician->password = Hash::make('password');
                $employee_technician->save();
            }
        }

    }
}