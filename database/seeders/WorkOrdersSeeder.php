<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class WorkOrdersSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // for ($i = 1; $i <= 50; $i++) {
        //     DB::table('work_order')->insert([
        //         'work_order_no' => $faker->unique()->uuid,
        //         'type' => $faker->randomElement(['Manual', 'Auto']),
        //         'status' => $faker->randomElement(['NEW', 'ACCEPTED', 'REJECTED', 'ASSIGNED_TECHNICIAN', 'STARTED', 'REJECTED_DIFFERENT_SKILL', 'REJECTED_MATERIAL', 'REJECTED_ACCESS', 'COMPLETED']),
        //         'priority' => $faker->randomElement(['High', 'Medium', 'Low']),
        //         'service_request_id' => $i,
        //         'status_changed_by' => 1,
        //         'assign_to_technician' => $faker->randomElement([6, 8]),
        //         'project_id' => rand(1, 50),
        //     ]);
        // }

        for ($i = 1; $i <= 50; $i++) {
            DB::table('work_order')->insert([
                'work_order_no' => $faker->unique()->uuid,
                'type' => $faker->randomElement(['Manual', 'Auto']),
                'status' => $faker->randomElement(['NEW','STARTED', 'COMPLETED']),
                'priority' => $faker->randomElement(['High', 'Medium', 'Low']),
                'service_request_id' => $i,
                'status_changed_by' => 1,
                'assigned_teamleader' => 3,
                'assign_to_technician' => rand(3, 7),
                'project_id' => rand(1, 50),
            ]);
        }
    }
}
