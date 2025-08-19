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

        $locationStates = DB::table('locations')
            ->join('districts', 'locations.district_id', '=', 'districts.id')
            ->join('states', 'districts.state_id', '=', 'states.id')
            ->pluck('states.prefix', 'locations.id')
            ->toArray();

        // Create 10 client companies
        for ($i = 1; $i <= 10; $i++) {
            DB::table('client_companies')->insert([
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

        $prefixMap = [
            'Billboard' => 'BB',
            'Tempboard' => 'TB',
            'Bunting'   => 'BT',
            'Banner'    => 'BN',
        ];

        // ✅ 3A. Insert actual billboard data (realistic example)
        $realBillboards = [
            [
                'location_id'           => 1,
                'site_number'           => 'SEL-001',
                'gps_latitude'          => $faker->latitude(1.2, 6.7),     // Malaysia approx. lat range
                'gps_longitude'         => $faker->longitude(99.6, 119.3), // Malaysia approx. lng range
                'traffic_volume'        => $faker->numerify('#######'),
                'size'                  => '30x20',
                'lighting'              => $faker->randomElement(['TNB', 'SOLAR', 'None']),
                'type'                  => 'Billboard',
                'prefix'                => 'BB',
                'status'                => 1,
                'created_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                'updated_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                ],
                [
                'location_id'           => 2,
                'site_number'           => 'SEL-002',
                'gps_latitude'          => $faker->latitude(1.2, 6.7),     // Malaysia approx. lat range
                'gps_longitude'         => $faker->longitude(99.6, 119.3), // Malaysia approx. lng range
                'traffic_volume'        => $faker->numerify('#######'),
                'size'                  => '30x20',
                'lighting'              => $faker->randomElement(['TNB', 'SOLAR', 'None']),
                'type'                  => 'Billboard',
                'prefix'                => 'BB',
                'status'                => 1,
                'created_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                'updated_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                ],
                [
                'location_id'           => 3,
                'site_number'           => 'SEL-005',
                'gps_latitude'          => $faker->latitude(1.2, 6.7),     // Malaysia approx. lat range
                'gps_longitude'         => $faker->longitude(99.6, 119.3), // Malaysia approx. lng range
                'traffic_volume'        => $faker->numerify('#######'),
                'size'                  => '30x20',
                'lighting'              => $faker->randomElement(['TNB', 'SOLAR', 'None']),
                'type'                  => 'Billboard',
                'prefix'                => 'BB',
                'status'                => 1,
                'created_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                'updated_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                ],
                [
                'location_id'           => 4,
                'site_number'           => 'SEL-006',
                'gps_latitude'          => $faker->latitude(1.2, 6.7),     // Malaysia approx. lat range
                'gps_longitude'         => $faker->longitude(99.6, 119.3), // Malaysia approx. lng range
                'traffic_volume'        => $faker->numerify('#######'),
                'size'                  => '30x20',
                'lighting'              => $faker->randomElement(['TNB', 'SOLAR', 'None']),
                'type'                  => 'Billboard',
                'prefix'                => 'BB',
                'status'                => 1,
                'created_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                'updated_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                ],
                [
                'location_id'           => 5,
                'site_number'           => 'SEL-007',
                'gps_latitude'          => $faker->latitude(1.2, 6.7),     // Malaysia approx. lat range
                'gps_longitude'         => $faker->longitude(99.6, 119.3), // Malaysia approx. lng range
                'traffic_volume'        => $faker->numerify('#######'),
                'size'                  => '30x20',
                'lighting'              => $faker->randomElement(['TNB', 'SOLAR', 'None']),
                'type'                  => 'Billboard',
                'prefix'                => 'BB',
                'status'                => 1,
                'created_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                'updated_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                ],
                [
                'location_id'           => 6,
                'site_number'           => 'WPK-001',
                'gps_latitude'          => $faker->latitude(1.2, 6.7),     // Malaysia approx. lat range
                'gps_longitude'         => $faker->longitude(99.6, 119.3), // Malaysia approx. lng range
                'traffic_volume'        => $faker->numerify('#######'),
                'size'                  => '30x20',
                'lighting'              => $faker->randomElement(['TNB', 'SOLAR', 'None']),
                'type'                  => 'Tempboard',
                'prefix'                => 'TB',
                'status'                => 1,
                'created_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                'updated_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                ],
                [
                'location_id'           => 7,
                'site_number'           => 'WPK-002',
                'gps_latitude'          => $faker->latitude(1.2, 6.7),     // Malaysia approx. lat range
                'gps_longitude'         => $faker->longitude(99.6, 119.3), // Malaysia approx. lng range
                'traffic_volume'        => $faker->numerify('#######'),
                'size'                  => '30x20',
                'lighting'              => $faker->randomElement(['TNB', 'SOLAR', 'None']),
                'type'                  => 'Tempboard',
                'prefix'                => 'TB',
                'status'                => 1,
                'created_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                'updated_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                ],
                [
                'location_id'           => 8,
                'site_number'           => 'WPK-003',
                'gps_latitude'          => $faker->latitude(1.2, 6.7),     // Malaysia approx. lat range
                'gps_longitude'         => $faker->longitude(99.6, 119.3), // Malaysia approx. lng range
                'traffic_volume'        => $faker->numerify('#######'),
                'size'                  => '30x20',
                'lighting'              => $faker->randomElement(['TNB', 'SOLAR', 'None']),
                'type'                  => 'Tempboard',
                'prefix'                => 'TB',
                'status'                => 1,
                'created_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                'updated_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                ],
                [
                'location_id'           => 9,
                'site_number'           => 'WPK-004',
                'gps_latitude'          => $faker->latitude(1.2, 6.7),     // Malaysia approx. lat range
                'gps_longitude'         => $faker->longitude(99.6, 119.3), // Malaysia approx. lng range
                'traffic_volume'        => $faker->numerify('#######'),
                'size'                  => '30x20',
                'lighting'              => $faker->randomElement(['TNB', 'SOLAR', 'None']),
                'type'                  => 'Tempboard',
                'prefix'                => 'TB',
                'status'                => 1,
                'created_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                'updated_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                ],
                [
                'location_id'           => 10,
                'site_number'           => 'WPK-005',
                'gps_latitude'          => $faker->latitude(1.2, 6.7),     // Malaysia approx. lat range
                'gps_longitude'         => $faker->longitude(99.6, 119.3), // Malaysia approx. lng range
                'traffic_volume'        => $faker->numerify('#######'),
                'size'                  => '30x20',
                'lighting'              => $faker->randomElement(['TNB', 'SOLAR', 'None']),
                'type'                  => 'Tempboard',
                'prefix'                => 'TB',
                'status'                => 1,
                'created_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                'updated_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                ],

        ];

        DB::table('billboards')->insert($realBillboards);

        // ✅ 3. Create billboards
        for ($i = 1; $i <= 50; $i++) {
            $type = $faker->randomElement(array_keys($prefixMap));
            $prefix = $prefixMap[$type];

            // Pick a random location_id
            $locationId = $faker->randomElement(array_keys($locationStates));

            // Get state prefix (e.g., SEL) from our map
            $statePrefix = $locationStates[$locationId] ?? 'XXX'; // fallback if missing

            // Running number with 4 digits
            $runningNumber = str_pad($i, 4, '0', STR_PAD_LEFT);

            // Final site number: BB-SEL-0001-A
            $siteNumber = "{$prefix}-{$statePrefix}-{$runningNumber}-A";

            DB::table('billboards')->insert([
                'location_id'           => $locationId,
                'site_number'           => $siteNumber,
                'gps_latitude'          => $faker->latitude(1.2, 6.7),     // Malaysia approx. lat range
                'gps_longitude'         => $faker->longitude(99.6, 119.3), // Malaysia approx. lng range
                'traffic_volume'        => $faker->numerify('#######'),
                'size'                  => $faker->randomElement(['15x10', '12x15', '10x10', '12x12', '8x8']),
                'lighting'              => $faker->randomElement(['TNB', 'SOLAR', 'None']),
                'type'                  => $type,
                'prefix'                => $prefix,
                'status'                => 1,
                'created_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
                'updated_at'            => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(), // Random timestamp between today and 10 days ago
            ]);
        }

        // ✅ 4. Pluck billbnards IDs
        $billboardIds = Billboard::pluck('id')->toArray();

        $globalRunningNumber = 0;

        // 5: Create non-overlapping bookings with at least 30-day gaps
        foreach ($billboardIds as $billboardId) {
            $currentStart = Carbon::create(2025, 1, 1); // Seed for year 2025
            $billboard = Billboard::find($billboardId);
            $prefix = $billboard->prefix; // BB, TB, etc.

            // Fixed status per billboard
            $billboardStatus = $faker->randomElement(['ongoing', 'pending_install', 'pending_payment']);

            for ($j = 0; $j < rand(2, 5); $j++) {
                // Random booking duration: 1 to 12 months
                $months = rand(1, 12);
                $end = (clone $currentStart)->addMonthsNoOverflow($months)->subDay(); // end is inclusive

                // Prevent exceeding year 2025
                if ($end->year > 2025) {
                    break;
                }

                // Generate job_order_no
                $monthYear = $currentStart->format('my'); // MMYY
                $globalRunningNumber++;
                $runningNumber = str_pad($globalRunningNumber, 5, '0', STR_PAD_LEFT);
                $jobOrderNo = "{$prefix}-{$monthYear}-{$runningNumber}";

                DB::table('billboard_bookings')->insert([
                    'billboard_id'   => $billboardId,
                    'company_id'     => $faker->randomElement($companyIds),
                    'job_order_no'   => $jobOrderNo,
                    'start_date'     => $currentStart->toDateString(),
                    'end_date'       => $end->toDateString(),
                    'status'         => $billboardStatus,
                    'artwork_by'     => $faker->randomElement(['Bluedale', 'clients']),
                    'dbp_approval'   => $faker->randomElement(['Approved', 'Rejected', 'In Review']),
                    'remarks'        => $faker->sentence(),
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

                // Next booking starts right after previous ends
                $currentStart = (clone $end)->addDay();
            }
        }




        // 6. Attach 2 images to first 10 billboards
        for ($i = 1; $i <= 50; $i++) {
            DB::table('billboard_images')->insert([
                [
                    'billboard_id' => $i,
                    'image_path'   => "images/billboards/sample_{$i}_1.jpg",
                    'image_type'   => "jpg",
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ],
                [
                    'billboard_id' => $i,
                    'image_path'   => "images/billboards/sample_{$i}_2.jpg",
                    'image_type'   => "jpg",
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ],
            ]);
        }

        // 7. Create monthly_ongoing_jobs from billboard_bookings
        $bookingJobs = DB::table('billboard_bookings')->get();

        foreach ($bookingJobs as $booking) {
            $start = Carbon::parse($booking->start_date)->startOfMonth();
            $end = Carbon::parse($booking->end_date)->startOfMonth();

            while ($start <= $end) {
                DB::table('monthly_ongoing_jobs')->insert([
                    'booking_id'     => $booking->id,
                    'month'      => $start->month,
                    'year'       => $start->year,
                    'status'     => fake()->randomElement(['pending', 'in_progress', 'completed']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $start->addMonth();
            }
        }
    }
}
