<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon as Carbon;

class v02_serviceRequest extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $projectTypes = ['open', 'renew', 'new'];

        for ($i = 0; $i < 50; $i++) {
            $companyPrefix = $faker->randomLetter . $faker->randomLetter . $faker->randomLetter . $faker->randomLetter;
            DB::table('client_company')->insert([
                'name' => $faker->company,
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'company_prefix' => $companyPrefix,
            ]);
        }

        for ($i = 1; $i <= 50; $i++) {
            $fromDate = $faker->dateTimeBetween('-1 year', 'now');
            $toDate = $faker->dateTimeInInterval($fromDate, '+3 days');

            DB::table('projects')->insert([
                'project_prefix' => $faker->word,
                'from_date' => $fromDate,
                'to_date' => $toDate,
                'type' => $faker->randomElement($projectTypes),
                'client_company_id' => $faker->numberBetween(1, 50),
            ]);
        }

        for ($i = 1; $i <= 50; $i++) {
            DB::table('clients')->insert([
                'name' => $faker->company,
                'contact' => $faker->phoneNumber,
                'company_id' => $i,
                'user_id' => 2,
            ]);
        }

        // for ($i = 1; $i <= 50; $i++) {
        //     DB::table('service_request')->insert([
        //         'service_request_no' => $faker->unique()->uuid,
        //         'description' => $faker->sentence,
        //         'location' => $faker->randomElement(['15F Meeting Room', '20F Washroom', 'Lobby', '31F Rooftop', '19F Open Office']),
        //         'status' => $faker->randomElement(['NEW', 'ACCEPTED', 'REJECTED', 'CLOSED']),
        //         'remarks_by_client' => $faker->sentence,
        //         'remarks_by_occ' => $faker->sentence,
        //         'sr_sub_category_id'=>rand(1, 60),
        //         'sr_category_id'=>rand(1,12),
        //         'raise_by' => $faker->randomElement([1, 2]),
        //         'project_id' => rand(1, 50), // Change this line
        //         'created_at' => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
        //         'updated_at' => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
        //     ]);
        // }

        for ($i = 1; $i <= 50; $i++) {
            DB::table('service_request')->insert([
                'service_request_no' => $faker->unique()->uuid,
                'description' => $faker->sentence,
                'location' => $faker->randomElement(['ONSITE', 'OFFSITE']),
                'status' => $faker->randomElement(['NEW', 'ACCEPTED', 'CLOSED']),
                'remarks_by_client' => $faker->sentence,
                'sr_sub_category_id'=>rand(1, 3),
                'sr_category_id'=>rand(1,7),
                'raise_by' => $faker->randomElement([1, 2]),
                'project_id' => rand(1, 50), // Change this line
                'created_at' => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                'updated_at' => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
            ]);
        }

        // for ($i = 0; $i < 20; $i++) {
        //     Employee::create([
        //         'name' => $faker->name,
        //         'contact' => $faker->phoneNumber,
        //         'position' => $faker->jobTitle,
        //         'user_id' => rand(2, 6), // Adjust user ID range as needed
        //         'status' => 1, // Randomly set status to 1 or 2
        //         'deleted_at' => null,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }

        // Employee::create([
        //     'name' => $faker->name,
        //     'contact' => $faker->phoneNumber,
        //     'position' => $faker->jobTitle,
        //     'user_id' => 3,
        //     'status' => 1,
        //     'deleted_at' => null,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // Employee::create([
        //     'name' => $faker->name,
        //     'contact' => $faker->phoneNumber,
        //     'position' => $faker->jobTitle,
        //     'user_id' => 4,
        //     'status' => 1,
        //     'deleted_at' => null,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // Employee::create([
        //     'name' => $faker->name,
        //     'contact' => $faker->phoneNumber,
        //     'position' => $faker->jobTitle,
        //     'user_id' => 5,
        //     'status' => 1,
        //     'deleted_at' => null,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // Employee::create([
        //     'name' => $faker->name,
        //     'contact' => $faker->phoneNumber,
        //     'position' => $faker->jobTitle,
        //     'user_id' => 6,
        //     'status' => 1,
        //     'deleted_at' => null,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // for ($i = 0; $i < 5; $i++) {
        //     OnsiteTeam::create([
        //         'team_name' => $faker->company,
        //         'project_id' => rand(1, 50), // Adjust project ID range as needed
        //         'type' => $faker->randomElement(['Design', 'Development', 'Marketing']),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }

        // Get employee and team IDs
        // $employeeIds = array_unique(range(1, 20)); // Adjust employee ID range
        // $teamIds = range(1, 5); // Adjust team ID range

        // for ($i = 0; $i < 20; $i++) {
        //     $randomEmployee = array_rand($employeeIds);
        //     $randomTeam = array_rand($teamIds);

        //     OnsiteTeamMembers::create([
        //         // 'employee_id' => $employeeIds[$randomEmployee],
        //         'employee_id' => 4,
        //         'onsite_team_id' => $teamIds[$randomTeam],
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }
    }
}
