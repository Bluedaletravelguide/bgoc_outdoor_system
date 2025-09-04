<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contractor;
use Faker\Factory as Faker;

class ContractorSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $data = [
            [
                'company_name' => 'Bluedale Group Of Companies',
                'name' => 'BGOC',
                'phone' => '+60122200622'
            ],
            [
                'company_name' => 'Mahamad Advertising',
                'name' => 'Arun',
                'phone' => $faker->phoneNumber(), // random phone
            ],
            [
                'company_name' => 'TCK Loga Enterprise',
                'name' => 'Waqas',
                'phone' => $faker->phoneNumber(),
            ],
            [
                'company_name' => 'Fahad Ali',
                'name' => 'Fahad',
                'phone' => $faker->phoneNumber(),
            ],
            [
                'company_name' => 'Muhammad Naveed',
                'name' => 'Naveed',
                'phone' => $faker->phoneNumber(),
            ],
            [
                'company_name' => 'Cheema Jaya Enterprise',
                'name' => 'Bilal',
                'phone' => $faker->phoneNumber(),
            ],
            [
                'company_name' => 'PBS Outsource',
                'name' => 'Faisal',
                'phone' => $faker->phoneNumber(),
            ],
        ];

        Contractor::insert($data);
    }
}
