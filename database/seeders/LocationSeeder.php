<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;
use App\Models\District;
use App\Models\Council;
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
        Council::truncate();
        District::truncate();
        State::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            // 🟣 SELANGOR
            "Selangor" => [
                "prefix" => "SEL",
                "districts" => ["Petaling", "Klang", "Hulu Langat", "Gombak", "Kuala Selangor", "Sabak Bernam", "Kuala Langat", "Hulu Selangor"],
                "councils" => [
                    ["name" => "Majlis Bandaraya Petaling Jaya", "abbreviation" => "MBPJ"],
                    ["name" => "Majlis Bandaraya Shah Alam", "abbreviation" => "MBSA"],
                    ["name" => "Majlis Bandaraya Subang Jaya", "abbreviation" => "MBSJ"],
                    ["name" => "Majlis Perbandaran Klang", "abbreviation" => "MPK"],
                    ["name" => "Majlis Perbandaran Selayang", "abbreviation" => "MPS"],
                    ["name" => "Majlis Daerah Kuala Selangor", "abbreviation" => "MDKS"],
                    ["name" => "Majlis Daerah Hulu Selangor", "abbreviation" => "MDHS"],
                    ["name" => "Majlis Daerah Kuala Langat", "abbreviation" => "MDKL"],
                ]
            ],

            // 🟣 KUALA LUMPUR (Federal Territory)
            "Kuala Lumpur" => [
                "prefix" => "KUL",
                "districts" => ["Bukit Bintang", "Cheras", "Kepong", "Lembah Pantai", "Segambut", "Setiawangsa", "Titiwangsa", "Wangsa Maju"],
                "councils" => [
                    ["name" => "Dewan Bandaraya Kuala Lumpur", "abbreviation" => "DBKL"],
                ]
            ],

            // 🟣 PUTRAJAYA
            "Putrajaya" => [
                "prefix" => "PJA",
                "districts" => ["Precinct 1", "Precinct 2", "Precinct 3", "Precinct 4"],
                "councils" => [
                    ["name" => "Perbadanan Putrajaya", "abbreviation" => "PPJ"],
                ]
            ],

            // 🟣 LABUAN
            "Labuan" => [
                "prefix" => "LAB",
                "districts" => ["Labuan Town"],
                "councils" => [
                    ["name" => "Perbadanan Labuan", "abbreviation" => "PL"],
                ]
            ],

            // 🟣 JOHOR
            "Johor" => [
                "prefix" => "JOH",
                "districts" => ["Johor Bahru", "Batu Pahat", "Kluang", "Muar", "Segamat", "Pontian", "Kulai", "Kota Tinggi"],
                "councils" => [
                    ["name" => "Majlis Bandaraya Johor Bahru", "abbreviation" => "MBJB"],
                    ["name" => "Majlis Bandaraya Iskandar Puteri", "abbreviation" => "MBIP"],
                    ["name" => "Majlis Perbandaran Batu Pahat", "abbreviation" => "MPBP"],
                    ["name" => "Majlis Perbandaran Kluang", "abbreviation" => "MPKu"],
                    ["name" => "Majlis Perbandaran Muar", "abbreviation" => "MPMuar"],
                    ["name" => "Majlis Daerah Segamat", "abbreviation" => "MDS"],
                ]
            ],

            // 🟣 PENANG
            "Pulau Pinang" => [
                "prefix" => "PNG",
                "districts" => ["Timur Laut", "Barat Daya", "Seberang Perai Utara", "Seberang Perai Tengah", "Seberang Perai Selatan"],
                "councils" => [
                    ["name" => "Majlis Bandaraya Pulau Pinang", "abbreviation" => "MBPP"],
                    ["name" => "Majlis Bandaraya Seberang Perai", "abbreviation" => "MBSP"],
                ]
            ],

            // 🟣 PERAK
            "Perak" => [
                "prefix" => "PRK",
                "districts" => ["Kinta", "Larut Matang", "Hilir Perak", "Kuala Kangsar", "Manjung", "Perak Tengah"],
                "councils" => [
                    ["name" => "Majlis Bandaraya Ipoh", "abbreviation" => "MBI"],
                    ["name" => "Majlis Perbandaran Taiping", "abbreviation" => "MPT"],
                    ["name" => "Majlis Perbandaran Teluk Intan", "abbreviation" => "MPTI"],
                ]
            ],

            // 🟣 PAHANG
            "Pahang" => [
                "prefix" => "PHG",
                "districts" => ["Kuantan", "Temerloh", "Bentong", "Raub", "Maran", "Pekan"],
                "councils" => [
                    ["name" => "Majlis Bandaraya Kuantan", "abbreviation" => "MBK"],
                    ["name" => "Majlis Daerah Temerloh", "abbreviation" => "MDT"],
                    ["name" => "Majlis Daerah Bentong", "abbreviation" => "MDB"],
                ]
            ],

            // 🟣 KEDAH
            "Kedah" => [
                "prefix" => "KDH",
                "districts" => ["Alor Setar", "Sungai Petani", "Kulim", "Langkawi"],
                "councils" => [
                    ["name" => "Majlis Bandaraya Alor Setar", "abbreviation" => "MBAS"],
                    ["name" => "Majlis Perbandaran Sungai Petani", "abbreviation" => "MPSPK"],
                    ["name" => "Majlis Daerah Langkawi", "abbreviation" => "MDL"],
                ]
            ],

            // 🟣 KELANTAN
            "Kelantan" => [
                "prefix" => "KTN",
                "districts" => ["Kota Bharu", "Pasir Mas", "Tanah Merah", "Tumpat"],
                "councils" => [
                    ["name" => "Majlis Perbandaran Kota Bharu", "abbreviation" => "MPKB"],
                ]
            ],

            // 🟣 TERENGGANU
            "Terengganu" => [
                "prefix" => "TRG",
                "districts" => ["Kuala Terengganu", "Kemaman", "Dungun", "Marang"],
                "councils" => [
                    ["name" => "Majlis Bandaraya Kuala Terengganu", "abbreviation" => "MBKT"],
                    ["name" => "Majlis Perbandaran Dungun", "abbreviation" => "MPD"],
                ]
            ],

            // 🟣 MELAKA
            "Melaka" => [
                "prefix" => "MLK",
                "districts" => ["Melaka Tengah", "Alor Gajah", "Jasin"],
                "councils" => [
                    ["name" => "Majlis Bandaraya Melaka Bersejarah", "abbreviation" => "MBMB"],
                    ["name" => "Majlis Perbandaran Alor Gajah", "abbreviation" => "MPAG"],
                    ["name" => "Majlis Perbandaran Jasin", "abbreviation" => "MPJ"],
                ]
            ],

            // 🟣 NEGERI SEMBILAN
            "Negeri Sembilan" => [
                "prefix" => "NSN",
                "districts" => ["Seremban", "Port Dickson", "Jempol"],
                "councils" => [
                    ["name" => "Majlis Bandaraya Seremban", "abbreviation" => "MBS"],
                    ["name" => "Majlis Perbandaran Port Dickson", "abbreviation" => "MPPD"],
                ]
            ],

            // 🟣 PERLIS
            "Perlis" => [
                "prefix" => "PLS",
                "districts" => ["Kangar", "Arau", "Padang Besar"],
                "councils" => [
                    ["name" => "Majlis Perbandaran Kangar", "abbreviation" => "MPKgr"],
                ]
            ],

            // 🟣 SABAH
            "Sabah" => [
                "prefix" => "SBH",
                "districts" => ["Kota Kinabalu", "Sandakan", "Tawau", "Lahad Datu"],
                "councils" => [
                    ["name" => "Dewan Bandaraya Kota Kinabalu", "abbreviation" => "DBKK"],
                    ["name" => "Majlis Perbandaran Sandakan", "abbreviation" => "MPS"],
                    ["name" => "Majlis Perbandaran Tawau", "abbreviation" => "MPT"],
                ]
            ],

            // 🟣 SARAWAK
            "Sarawak" => [
                "prefix" => "SWK",
                "districts" => ["Kuching", "Miri", "Sibu", "Bintulu"],
                "councils" => [
                    ["name" => "Majlis Bandaraya Kuching Selatan", "abbreviation" => "MBKS"],
                    ["name" => "Dewan Bandaraya Kuching Utara", "abbreviation" => "DBKU"],
                    ["name" => "Majlis Bandaraya Miri", "abbreviation" => "MBM"],
                    ["name" => "Majlis Perbandaran Sibu", "abbreviation" => "MPSibu"],
                ]
            ],
        ];

        // 🔄 Loop through states, districts, councils
        foreach ($data as $stateName => $info) {
            $state = State::create([
                'name' => $stateName,
                'prefix' => $info['prefix']
            ]);

            $districts = [];
            foreach ($info['districts'] as $districtName) {
                $districts[$districtName] = District::create([
                    'name' => $districtName,
                    'state_id' => $state->id,
                ]);
            }

            $councils = [];
            foreach ($info['councils'] as $councilData) {
                $councils[$councilData['abbreviation']] = Council::create([
                    'name' => $councilData['name'],
                    'abbreviation' => $councilData['abbreviation'],
                    'state_id' => $state->id,
                ]);
            }

            // 🌍 Sample Locations
            foreach ($districts as $districtName => $district) {
                foreach ($councils as $council) {
                    for ($i = 1; $i <= 2; $i++) {
                        Location::create([
                            'name' => "{$districtName} Location $i",
                            'district_id' => $district->id,
                            'council_id' => $council->id,
                        ]);
                    }
                }
            }
        }

        // 🟣 Special Council: KKR (no state)
        Council::create([
            'name' => 'Kementerian Kerja Raya',
            'abbreviation' => 'KKR',
            'state_id' => null,   // ✅ no state
        ]);
    }
}
