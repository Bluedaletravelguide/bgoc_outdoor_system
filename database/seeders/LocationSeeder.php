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
                "districts" => ["Petaling", "Diraja Klang", "Hulu Langat", "Gombak", "Kuala Selangor", "Sabak Bernam", "Kuala Langat", "Hulu Selangor", "Ampang Jaya","Kajang", "Sabak Bernam", "Sepang"],
                "councils" => [
                    ["name" => "Majlis Bandaraya Petaling Jaya", "abbreviation" => "MBPJ"],
                    ["name" => "Majlis Bandaraya Shah Alam", "abbreviation" => "MBSA"],
                    ["name" => "Majlis Bandaraya Subang Jaya", "abbreviation" => "MBSJ"],
                    ["name" => "Majlis Perbandaran Diraja Klang", "abbreviation" => "MPDK"],
                    ["name" => "Majlis Perbandaran Ampang Jaya", "abbreviation" => "MPAJ"],
                    ["name" => "Majlis Perbandaran Selayang", "abbreviation" => "MPS"],
                    ["name" => "Majlis Daerah Kuala Selangor", "abbreviation" => "MDKS"],
                    ["name" => "Majlis Daerah Hulu Selangor", "abbreviation" => "MDHS"],
                    ["name" => "Majlis Perbandaran Kajang", "abbreviation" => "MPKJ"],
                    ["name" => "Majlis Daerah Sabak Bernam", "abbreviation" => "MDSB"],
                    ["name" => "Majlis Daerah Sepang", "abbreviation" => "MPSepang"],
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
                "districts" => [
                    "Johor Bahru",
                    "Batu Pahat",
                    "Kluang",
                    "Muar",
                    "Segamat",
                    "Pontian",
                    "Kulai",
                    "Kota Tinggi",
                    "Mersing",
                    "Tangkak",
                ],
                "councils" => [
                    ["name" => "Majlis Bandaraya Johor Bahru",     "abbreviation" => "MBJB"],
                    ["name" => "Majlis Bandaraya Iskandar Puteri",  "abbreviation" => "MBIP"],
                    ["name" => "Majlis Perbandaran Batu Pahat",     "abbreviation" => "MPBP"],
                    ["name" => "Majlis Perbandaran Kluang",         "abbreviation" => "MPKluang"],
                    ["name" => "Majlis Perbandaran Muar",           "abbreviation" => "MPMuar"],
                    ["name" => "Majlis Perbandaran Segamat",        "abbreviation" => "MPSegamat"],
                    ["name" => "Majlis Perbandaran Kulai",          "abbreviation" => "MPKulai"],
                    ["name" => "Majlis Perbandaran Pontian",        "abbreviation" => "MPPn"],
                    ["name" => "Majlis Perbandaran Pengerang",      "abbreviation" => "MPPengerang"],
                    ["name" => "Majlis Bandaraya Pasir Gudang",     "abbreviation" => "MBPG"],
                    ["name" => "Majlis Daerah Kota Tinggi",         "abbreviation" => "MDKT"],
                    ["name" => "Majlis Daerah Mersing",             "abbreviation" => "MDMersing"],
                    ["name" => "Majlis Daerah Tangkak",             "abbreviation" => "MDTangkak"],
                    ["name" => "Majlis Daerah Simpang Renggam",     "abbreviation" => "MDSR"],
                    ["name" => "Majlis Daerah Labis",               "abbreviation" => "MDLabis"],
                    ["name" => "Majlis Daerah Yong Peng",           "abbreviation" => "MDYP"],
                ],
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
                "districts" => [
                    "Kinta",
                    "Larut Matang",
                    "Hilir Perak",
                    "Kuala Kangsar",
                    "Manjung",
                    "Perak Tengah",
                    "Selama",
                    "Batu Gajah",
                    "Kampar",
                    "Gerik",
                    "Lenggong",
                    "Pengkalan Hulu",
                    "Tapah",
                    "Tanjong Malim",
                    "Kerian",
                ],
                "councils" => [
                    ["name" => "Majlis Bandaraya Ipoh", "abbreviation" => "MBI"],
                    ["name" => "Majlis Perbandaran Taiping", "abbreviation" => "MPTaiping"],
                    ["name" => "Majlis Perbandaran Manjung", "abbreviation" => "MPM"],
                    ["name" => "Majlis Daerah Perak Tengah", "abbreviation" => "MDPT"],
                    ["name" => "Majlis Perbandaran Kuala Kangsar", "abbreviation" => "MPKKPK"],
                    ["name" => "Majlis Daerah Selama", "abbreviation" => "MDSelama"],
                    ["name" => "Majlis Daerah Batu Gajah", "abbreviation" => "MDBG"],
                    ["name" => "Majlis Daerah Kampar", "abbreviation" => "MDKampar"],
                    ["name" => "Majlis Daerah Gerik", "abbreviation" => "MDG"],
                    ["name" => "Majlis Daerah Lenggong", "abbreviation" => "MDLG"],
                    ["name" => "Majlis Daerah Pengkalan Hulu", "abbreviation" => "MDPH"],
                    ["name" => "Majlis Daerah Tapah", "abbreviation" => "MDTapah"],
                    ["name" => "Majlis Daerah Tanjong Malim", "abbreviation" => "MDTM"],
                    ["name" => "Majlis Perbandaran Teluk Intan", "abbreviation" => "MPTI"],
                    ["name" => "Majlis Daerah Kerian", "abbreviation" => "MDKerian"],
                ],
            ],

            // 🟣 PAHANG
            "Pahang" => [
                "prefix" => "PHG",
                "districts" => [
                    "Kuantan",
                    "Temerloh",
                    "Bentong",
                    "Pekan",
                    "Kuala Lipis",
                    "Cameron Highlands",
                    "Raub",
                    "Bera",
                    "Maran",
                    "Rompin",
                    "Jerantut",
                ],
                "councils" => [
                    ["name" => "Majlis Bandaraya Kuantan", "abbreviation" => "MBK"],
                    ["name" => "Majlis Perbandaran Temerloh", "abbreviation" => "MPT"],
                    ["name" => "Majlis Perbandaran Bentong", "abbreviation" => "MPBENTONG"],
                    ["name" => "Majlis Perbandaran Pekan Bandar Diraja", "abbreviation" => "MPPekan"],
                    ["name" => "Majlis Daerah Lipis", "abbreviation" => "MDLipis"],
                    ["name" => "Majlis Daerah Cameron Highlands", "abbreviation" => "MDCH"],
                    ["name" => "Majlis Daerah Raub", "abbreviation" => "MDRaub"],
                    ["name" => "Majlis Daerah Bera", "abbreviation" => "MDBera"],
                    ["name" => "Majlis Daerah Maran", "abbreviation" => "MDMaran"],
                    ["name" => "Majlis Daerah Rompin", "abbreviation" => "MDRompin"],
                    ["name" => "Majlis Daerah Jerantut", "abbreviation" => "MDJerantut"],
                ],
            ],

            // 🟣 KEDAH
            "Kedah" => [
                "prefix" => "KDH",
                "districts" => [
                    "Alor Setar",
                    "Sungai Petani",
                    "Kulim",
                    "Kubang Pasu",
                    "Baling",
                    "Yan",
                    "Sik",
                    "Pendang",
                    "Padang Terap",
                    "Bandar Baharu",
                    "Langkawi",
                ],
                "councils" => [
                    ["name" => "Majlis Bandaraya Alor Setar", "abbreviation" => "MBAS"],
                    ["name" => "Majlis Perbandaran Sungai Petani", "abbreviation" => "MPSPK"],
                    ["name" => "Majlis Perbandaran Kulim", "abbreviation" => "MPKK"],
                    ["name" => "Majlis Perbandaran Kubang Pasu", "abbreviation" => "MPKPasu"],
                    ["name" => "Majlis Perbandaran Langkawi Bandaraya Pelancongan", "abbreviation" => "MPL"],
                    ["name" => "Majlis Daerah Baling", "abbreviation" => "MDBaling"],
                    ["name" => "Majlis Daerah Yan", "abbreviation" => "MDYan"],
                    ["name" => "Majlis Daerah Sik", "abbreviation" => "MDSik"],
                    ["name" => "Majlis Daerah Pendang", "abbreviation" => "MDPendang"],
                    ["name" => "Majlis Daerah Padang Terap", "abbreviation" => "MDPTerap"],
                    ["name" => "Majlis Daerah Bandar Baharu", "abbreviation" => "MDBB"],
                ],
            ],


            // 🟣 KELANTAN
            "Kelantan" => [
                "prefix" => "KTN",
                "districts" => [
                    "Kota Bharu",
                    "Bachok",
                    "Gua Musang",
                    "Jeli",
                    "Ketereh",
                    "Dabong",
                    "Kuala Krai",
                    "Machang",
                    "Pasir Mas",
                    "Pasir Puteh",
                    "Tanah Merah",
                    "Tumpat",
                ],
                "councils" => [
                    ["name" => "Majlis Perbandaran Kota Bharu - Bandar Raya Islam", "abbreviation" => "MPKBBRI"],
                    ["name" => "Majlis Daerah Bachok Bandar Pelancongan Islam", "abbreviation" => "MDBachok"],
                    ["name" => "Majlis Daerah Gua Musang", "abbreviation" => "MDGM"],
                    ["name" => "Majlis Daerah Jeli", "abbreviation" => "MDJeli"],
                    ["name" => "Majlis Daerah Ketereh - Perbandaran Islam", "abbreviation" => "MDKetereh"],
                    ["name" => "Majlis Daerah Dabong", "abbreviation" => "MDDabong"],
                    ["name" => "Majlis Daerah Kuala Krai", "abbreviation" => "MDKK"],
                    ["name" => "Majlis Daerah Machang", "abbreviation" => "MDMachang"],
                    ["name" => "Majlis Daerah Pasir Mas", "abbreviation" => "MDPM"],
                    ["name" => "Majlis Daerah Pasir Puteh", "abbreviation" => "MDPP"],
                    ["name" => "Majlis Daerah Tanah Merah", "abbreviation" => "MDTMerah"],
                    ["name" => "Majlis Daerah Tumpat", "abbreviation" => "MDTumpat"],
                ],
            ],

            // 🟣 TERENGGANU
           "Terengganu" => [
                "prefix" => "TRG",
                "districts" => [
                    "Kuala Terengganu",
                    "Besut",
                    "Setiu",
                    "Dungun",
                    "Hulu Terengganu",
                    "Kemaman",
                    "Marang",
                ],
                "councils" => [
                    ["name" => "Majlis Bandaraya Kuala Terengganu", "abbreviation" => "MBKT"],
                    ["name" => "Majlis Daerah Besut", "abbreviation" => "MDBesut"],
                    ["name" => "Majlis Daerah Setiu", "abbreviation" => "MDSetiu"],
                    ["name" => "Majlis Perbandaran Dungun", "abbreviation" => "MPDungun"],
                    ["name" => "Majlis Daerah Hulu Terengganu", "abbreviation" => "MDHT"],
                    ["name" => "Majlis Perbandaran Kemaman", "abbreviation" => "MPKemaman"],
                    ["name" => "Majlis Daerah Marang", "abbreviation" => "MDMarang"],
                ],
            ],


            // 🟣 MELAKA
            "Melaka" => [
                "prefix" => "MLK",
                "districts" => ["Melaka Tengah", "Alor Gajah", "Jasin", "Majlis Perbandaran Hang Tuah Jaya"],
                "councils" => [
                    ["name" => "Majlis Bandaraya Melaka Bersejarah", "abbreviation" => "MBMB"],
                    ["name" => "Majlis Perbandaran Alor Gajah", "abbreviation" => "MPAG"],
                    ["name" => "Majlis Perbandaran Majlis Perbandaran Hang Tuah Jaya", "abbreviation" => "	MPHTJ"],
                    ["name" => "Majlis Perbandaran Jasin", "abbreviation" => "MPJ"],
                ]
            ],

            // 🟣 NEGERI SEMBILAN
            "Negeri Sembilan" => [
                "prefix" => "NSN",
                "districts" => [
                    "Seremban",
                    "Port Dickson",
                    "Jempol",
                    "Kuala Pilah",
                    "Tampin",
                    "Jelebu",
                    "Rembau",
                ],
                "councils" => [
                    ["name" => "Majlis Bandaraya Seremban", "abbreviation" => "MBS"],
                    ["name" => "Majlis Daerah Kuala Pilah", "abbreviation" => "MDKP"],
                    ["name" => "Majlis Daerah Tampin", "abbreviation" => "MDTampin"],
                    ["name" => "Majlis Perbandaran Port Dickson", "abbreviation" => "MPPD"],
                    ["name" => "Majlis Daerah Jelebu", "abbreviation" => "MDJelebu"],
                    ["name" => "Majlis Daerah Rembau", "abbreviation" => "MDR"],
                    ["name" => "Majlis Perbandaran Jempol", "abbreviation" => "MPJL"],
                ],
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
                "districts" => [
                    "Kota Kinabalu",
                    "Sandakan",
                    "Tawau",
                    "Kudat",
                    "Beaufort",
                    "Beluran",
                    "Keningau",
                    "Kinabatangan",
                    "Kota Belud",
                    "Kota Marudu",
                    "Kuala Penyu",
                    "Kunak",
                    "Lahad Datu",
                    "Nabawan",
                    "Papar",
                    "Penampang",
                    "Ranau",
                    "Semporna",
                    "Sipitang",
                    "Tambunan",
                    "Tenom",
                    "Tuaran",
                    "Putatan",
                    "Pitas",
                    "Tongod",
                    "Telupid",
                ],
                "councils" => [
                    ["name" => "Dewan Bandaraya Kota Kinabalu", "abbreviation" => "DBKK"],
                    ["name" => "Majlis Perbandaran Sandakan", "abbreviation" => "MPS"],
                    ["name" => "Majlis Perbandaran Tawau", "abbreviation" => "MPT"],
                    ["name" => "Lembaga Bandaran Kudat", "abbreviation" => "LBK"],
                    ["name" => "Majlis Daerah Beaufort", "abbreviation" => "MDBeaufort"],
                    ["name" => "Majlis Daerah Beluran", "abbreviation" => "MDBeluran"],
                    ["name" => "Majlis Daerah Keningau", "abbreviation" => "MDKeningau"],
                    ["name" => "Majlis Daerah Kinabatangan", "abbreviation" => "MDKinabatangan"],
                    ["name" => "Majlis Daerah Kota Belud", "abbreviation" => "MDKB"],
                    ["name" => "Majlis Daerah Kota Marudu", "abbreviation" => "MDKM"],
                    ["name" => "Majlis Daerah Kuala Penyu", "abbreviation" => "MDKPenyu"],
                    ["name" => "Majlis Daerah Kunak", "abbreviation" => "MDKunak"],
                    ["name" => "Majlis Daerah Lahad Datu", "abbreviation" => "MDLD"],
                    ["name" => "Majlis Daerah Nabawan", "abbreviation" => "MDN"],
                    ["name" => "Majlis Daerah Papar", "abbreviation" => "MDPapar"],
                    ["name" => "Majlis Perbandaran Penampang", "abbreviation" => "MPPenampang"],
                    ["name" => "Majlis Daerah Ranau", "abbreviation" => "MDRanau"],
                    ["name" => "Majlis Daerah Semporna", "abbreviation" => "MDSemporna"],
                    ["name" => "Majlis Daerah Sipitang", "abbreviation" => "MDSipitang"],
                    ["name" => "Majlis Daerah Tambunan", "abbreviation" => "MDTambunan"],
                    ["name" => "Majlis Daerah Tenom", "abbreviation" => "MDTenom"],
                    ["name" => "Majlis Daerah Tuaran", "abbreviation" => "MDTuaran"],
                    ["name" => "Majlis Daerah Putatan", "abbreviation" => "MDPutatan"],
                    ["name" => "Majlis Daerah Pitas", "abbreviation" => "MDPitas"],
                    ["name" => "Majlis Daerah Tongod", "abbreviation" => "MDTongod"],
                    ["name" => "Majlis Daerah Telupid", "abbreviation" => "MDTelupid"],
                ],
            ],


            // 🟣 SARAWAK
            "Sarawak" => [
                "prefix" => "SWK",
                "districts" => [
                    "Bintulu",
                    "Kuching",
                    "Sibu",
                    "Miri",
                    "Bau",
                    "Betong",
                    "Mukah",
                    "Kanowit",
                    "Kapit",
                    "Lawas",
                    "Limbang",
                    "Lubok Antu",
                    "Lundu",
                    "Bintangor",
                    "Baram",
                    "Matu",
                    "Saratok",
                    "Kota Samarahan",
                    "Serian",
                    "Sarikei",
                    "Simunjan",
                    "Sri Aman",
                    "Bekenu",
                    "Gedong",
                ],
                "councils" => [
                    ["name" => "Lembaga Kemajuan Bintulu", "abbreviation" => "BDA"],
                    ["name" => "Dewan Bandaraya Kuching Utara", "abbreviation" => "DBKU"],
                    ["name" => "Majlis Bandaraya Kuching Selatan", "abbreviation" => "MBKS"],
                    ["name" => "Majlis Perbandaran Padawan", "abbreviation" => "MPP"],
                    ["name" => "Majlis Perbandaran Sibu", "abbreviation" => "SMC"],
                    ["name" => "Majlis Bandaraya Miri", "abbreviation" => "MBM"],
                    ["name" => "Majlis Daerah Bau", "abbreviation" => "BAUDC"],
                    ["name" => "Majlis Daerah Betong", "abbreviation" => "MDBetong"],
                    ["name" => "Majlis Daerah Dalat & Mukah", "abbreviation" => "MDDM"],
                    ["name" => "Majlis Daerah Kanowit", "abbreviation" => "MDKanowit"],
                    ["name" => "Majlis Daerah Kapit", "abbreviation" => "MDKapit"],
                    ["name" => "Majlis Daerah Lawas", "abbreviation" => "MDLawas"],
                    ["name" => "Majlis Daerah Limbang", "abbreviation" => "MDLimbang"],
                    ["name" => "Majlis Daerah Lubok Antu", "abbreviation" => "MDLA"],
                    ["name" => "Majlis Daerah Lundu", "abbreviation" => "MDLundu"],
                    ["name" => "Majlis Daerah Maradong & Julau", "abbreviation" => "MDMJ"],
                    ["name" => "Majlis Daerah Marudi", "abbreviation" => "MDM"],
                    ["name" => "Majlis Daerah Matu & Daro", "abbreviation" => "MDMD"],
                    ["name" => "Majlis Daerah Saratok", "abbreviation" => "MDSaratok"],
                    ["name" => "Majlis Perbandaran Kota Samarahan", "abbreviation" => "MPKS"],
                    ["name" => "Majlis Daerah Serian", "abbreviation" => "MDSerian"],
                    ["name" => "Majlis Daerah Sarikei", "abbreviation" => "MDSarikei"],
                    ["name" => "Majlis Daerah Simunjan", "abbreviation" => "MDSimunjan"],
                    ["name" => "Majlis Daerah Sri Aman", "abbreviation" => "MDSA"],
                    ["name" => "Majlis Daerah Subis", "abbreviation" => "MDSubis"],
                    ["name" => "Majlis Daerah Luar Bandar Sibu", "abbreviation" => "MDLBS"],
                    ["name" => "Majlis Daerah Gedong", "abbreviation" => "MDG"],
                ],
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
