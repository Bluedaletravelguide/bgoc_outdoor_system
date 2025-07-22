<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon as Carbon;
use App\Models\Billboard;
use App\Models\Client;
use App\Models\ClientCompany;
use App\Models\Location;

class BillboardSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Adjust as needed
        $clientIds = Client::pluck('id')->toArray();
        $locationIds = Location::pluck('id')->toArray();

        // Create 10 client companies
        for ($i = 1; $i <= 10; $i++) {
            DB::table('client_company')->insert([
                'company_prefix' => strtoupper($faker->lexify('????')),
                'name' => $faker->company,
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Then pluck the IDs to use for clients
        $companyIds = ClientCompany::pluck('id')->toArray();

        // ✅ 1. Create clients
        for ($i = 1; $i <= 15; $i++) {
            DB::table('clients')->insert([
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'designation' => $faker->randomElement(['Mr.', 'Mrs.', 'Ms.', 'Dato', 'Datin']),
                'company_id' => $faker->randomElement($companyIds),
                'created_at' => now(),
            ]);
        }

        // ✅ 2. Pluck client IDs
        $clientIds = Client::pluck('id')->toArray();

        // ✅ 3. Create billboards
        for ($i = 1; $i <= 50; $i++) {
            DB::table('billboards')->insert([
                'location_id' => $faker->randomElement($locationIds),
                'site_number' => strtoupper($faker->bothify('????-####')),
                'gps_latitude' => $faker->latitude(1.2, 6.7),     // Malaysia approx. lat range
                'gps_longitude' => $faker->longitude(99.6, 119.3), // Malaysia approx. lng range
                'traffic_volume' => $faker->numerify('#######'),
                'size'=> $faker->randomElement(['15x10', '12x15', '10x10', '12x12', '8x8']),
                'type'=> $faker->randomElement(['BB', 'TB', 'Bunting', 'Banner']),
                'lighting' => $faker->randomElement(['TNB', 'SOLAR', 'None']),
                'created_at' => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                'updated_at' => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
            ]);
        }

        // ✅ 4. Pluck billbnards IDs
        $billboardIds = Billboard::pluck('id')->toArray();

        // ✅ 5. Create bookings
        for ($i = 0; $i < 50; $i++) {
            $start = $faker->dateTimeBetween('+1 days', '+1 month');
            $end = (clone $start)->modify('+'.rand(3, 14).' days');

            DB::table('billboard_bookings')->insert([
                'billboard_id' => $faker->randomElement($billboardIds),
                'client_id' => $faker->randomElement($clientIds),
                'start_date' => $start->format('Y-m-d'),
                'end_date' => $end->format('Y-m-d'),
                'status' => $faker->randomElement(['ongoing', 'pending_install', 'pending_payment']),
                'artwork_by' => $faker->randomElement(['Bluedale', 'clients']),
                'dbp_approval' => $faker->randomElement(['Approved', 'Rejected', 'In Review']),
                'remarks' => $faker->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
