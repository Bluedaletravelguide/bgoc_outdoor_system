<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;
use App\Models\District;
use App\Models\Location;
use App\Models\Billboard;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Billboard::truncate();
        Location::truncate();
        District::truncate();
        State::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            "Selangor" => ["prefix" => "SEL", "districts" => ["Petaling", "Klang", "Hulu Langat", "Gombak", "Kuala Selangor", "Sabak Bernam", "Kuala Langat", "Hulu Selangor"]],
            "Kuala Lumpur" => ["prefix" => "KUL", "districts" => ["Bukit Bintang", "Cheras", "Kepong", "Lembah Pantai", "Segambut", "Setiawangsa", "Titiwangsa", "Wangsa Maju"]],
            "Johor" => ["prefix" => "JOH", "districts" => ["Johor Bahru", "Batu Pahat", "Kluang", "Muar", "Segamat", "Pontian", "Kulai", "Kota Tinggi"]],
            "Penang" => ["prefix" => "PNG", "districts" => ["Seberang Perai Utara", "Seberang Perai Tengah", "Seberang Perai Selatan", "Timur Laut", "Barat Daya"]],
            "Perak" => ["prefix" => "PRK", "districts" => ["Kinta", "Larut Matang", "Manjung", "Hilir Perak", "Batang Padang", "Kerian"]],
            "Sarawak" => ["prefix" => "SWK", "districts" => ["Kuching", "Sibu", "Bintulu", "Miri", "Sri Aman", "Limbang"]],
            "Sabah" => ["prefix" => "SBH", "districts" => ["Kota Kinabalu", "Sandakan", "Tawau", "Lahad Datu", "Keningau"]],
            "Negeri Sembilan" => ["prefix" => "NSN", "districts" => ["Seremban", "Port Dickson", "Tampin", "Jempol", "Jelebu", "Rembau"]],
            "Melaka" => ["prefix" => "MEL", "districts" => ["Melaka Tengah", "Alor Gajah", "Jasin"]],
            "Pahang" => ["prefix" => "PHG", "districts" => ["Kuantan", "Bentong", "Temerloh", "Raub", "Maran"]],
            "Terengganu" => ["prefix" => "TER", "districts" => ["Kuala Terengganu", "Dungun", "Kemaman", "Besut"]],
            "Kelantan" => ["prefix" => "KEL", "districts" => ["Kota Bharu", "Pasir Mas", "Tanah Merah", "Tumpat"]],
            "Kedah" => ["prefix" => "KED", "districts" => ["Alor Setar", "Kuala Muda", "Pendang", "Baling"]],
            "Perlis" => ["prefix" => "PLS", "districts" => ["Kangar", "Arau", "Padang Besar"]],
            "Putrajaya" => ["prefix" => "PJY", "districts" => ["Presint 1", "Presint 2", "Presint 3"]],
            "Labuan" => ["prefix" => "LBN", "districts" => ["Labuan"]],
        ];

        foreach ($data as $stateName => $info) {
            $state = State::create([
                'name' => $stateName,
                'prefix' => $info['prefix'] // Make sure this column exists in your `states` table
            ]);

            foreach ($info['districts'] as $districtName) {
                $district = District::create([
                    'name' => $districtName,
                    'state_id' => $state->id,
                ]);

                for ($i = 1; $i <= 3; $i++) {
                    Location::create([
                        'name' => "{$districtName} Location $i",
                        'district_id' => $district->id,
                    ]);
                }
            }
        }
    }

}
