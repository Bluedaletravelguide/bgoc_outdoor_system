<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;
use App\Models\District;
use App\Models\Location;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate child tables first
        DB::table('billboards')->truncate();
        DB::table('locations')->truncate();
        DB::table('districts')->truncate();
        DB::table('states')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            "Selangor" => ["Petaling", "Klang", "Hulu Langat", "Gombak", "Kuala Selangor", "Sabak Bernam", "Kuala Langat", "Hulu Selangor"],
            "Kuala Lumpur" => ["Bukit Bintang", "Cheras", "Kepong", "Lembah Pantai", "Segambut", "Setiawangsa", "Titiwangsa", "Wangsa Maju"],
            "Johor" => ["Johor Bahru", "Batu Pahat", "Kluang", "Muar", "Segamat", "Pontian", "Kulai", "Kota Tinggi"],
            "Penang" => ["Seberang Perai Utara", "Seberang Perai Tengah", "Seberang Perai Selatan", "Timur Laut", "Barat Daya"],
            "Perak" => ["Kinta", "Larut Matang", "Manjung", "Hilir Perak", "Batang Padang", "Kerian"],
            "Sarawak" => ["Kuching", "Sibu", "Bintulu", "Miri", "Sri Aman", "Limbang"],
            "Sabah" => ["Kota Kinabalu", "Sandakan", "Tawau", "Lahad Datu", "Keningau"],
            "Negeri Sembilan" => ["Seremban", "Port Dickson", "Tampin", "Jempol", "Jelebu", "Rembau"],
            "Melaka" => ["Melaka Tengah", "Alor Gajah", "Jasin"],
            "Pahang" => ["Kuantan", "Bentong", "Temerloh", "Raub", "Maran"],
            "Terengganu" => ["Kuala Terengganu", "Dungun", "Kemaman", "Besut"],
            "Kelantan" => ["Kota Bharu", "Pasir Mas", "Tanah Merah", "Tumpat"],
            "Kedah" => ["Alor Setar", "Kuala Muda", "Pendang", "Baling"],
            "Perlis" => ["Kangar", "Arau", "Padang Besar"],
            "Putrajaya" => ["Presint 1", "Presint 2", "Presint 3"],
            "Labuan" => ["Labuan"]
        ];

        foreach ($data as $stateName => $districts) {
            $state = State::create(['name' => $stateName]);

            foreach ($districts as $districtName) {
                $district = District::create([
                    'name' => $districtName,
                    'state_id' => $state->id,
                ]);

                // Create a few dummy locations under each district
                for ($i = 1; $i <= 3; $i++) {
                    Location::create([
                        'name' => "$districtName Location $i",
                        'district_id' => $district->id,
                    ]);
                }
            }
        }
    }
}
