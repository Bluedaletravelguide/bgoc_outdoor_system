<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Assets;
use Faker\Factory as Faker;
use Carbon\Carbon as Carbon;

class v05_AssetsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        // Seed asset categories
        for ($i = 1; $i <= 10; $i++) {
            DB::table('asset_category')->insert([
                'code' => 'category_code_' . $i,
                'name' => $faker->word,
                'description' => $faker->sentence,
            ]);
        }

        // Seed suppliers
        for ($i = 1; $i <= 10; $i++) {
            DB::table('suppliers')->insert([
                'code' => 'supplier_code_' . $i,
                'name' => $faker->company,
                'address' => $faker->address,
                'contact_person' => $faker->name,
                'phone' => $faker->phoneNumber,
                'fax' => $faker->optional()->phoneNumber,
                'email' => $faker->email,
                'description' => $faker->sentence,
            ]);
        }

        // Seed purchase orders
        for ($i = 1; $i <= 10; $i++) {
            $fromDate = $faker->dateTimeBetween('-1 year', 'now');
            $toDate = $faker->dateTimeInInterval($fromDate, '+3 days');
            
            DB::table('purchase_orders')->insert([
                'receipt_reference_number' => 'PO-123456-' . $i,
                'price' => $faker->randomFloat(2, 100, 1000),
                'purchase_date' => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(),
                'warranty_from' => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(),
                'warranty_until' => $faker->dateTimeInInterval($fromDate, '+3 days'),
                'description' => $faker->sentence,
                'supplier_id' => $i, // Assuming the supplier_id 1 to 10 exists
            ]);
        }

        // Seed locations
        for ($i = 1; $i <= 10; $i++) {
            DB::table('locations')->insert([
                'name' => 'Location ' . $i,
                'type' => $faker->randomElement(['building', 'level', 'department']),
            ]);
        }

        // Seed project has locations
        for ($i = 1; $i <= 10; $i++) {
            DB::table('project_has_locations')->insert([
                'contract_id' => $i, // Assuming the contract_id 1 to 10 exists
                'location_id' => $i, // Assuming the location_id 1 to 10 exists
            ]);
        }

        // Seed assets
        for ($i = 1; $i <= 10; $i++) {
            DB::table('assets')->insert([
                'code' => 'asset_code_' . $i,
                'name' => $faker->word,
                'description' => $faker->sentence,
                'asset_category_id' => $i, // Assuming the asset_category_id 1 to 10 exists
                'location_id' => $i, // Assuming the location_id 1 to 10 exists
                'purchase_order_id' => $i, // Assuming the purchase_order_id 1 to 10 exists
            ]);
        }
    }
}
