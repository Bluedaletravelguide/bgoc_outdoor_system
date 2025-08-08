<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClientCompany;
use App\Models\Contractor;

class ContractorSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'company_name' => 'Mahamad Advertising',
                'name' => 'Arun',
                'phone' => fake()->phoneNumber(), // random phone
            ],
            [
                'company_name' => 'TCK Loga Enterprise',
                'name' => 'Waqas',
                'phone' => fake()->phoneNumber(),
            ],
            [
                'company_name' => 'Fahad Ali',
                'name' => 'Fahad',
                'phone' => fake()->phoneNumber(), // random phone
            ],
            [
                'company_name' => 'Muhammad Naveed',
                'name' => 'Naveed',
                'phone' => fake()->phoneNumber(), // random phone
            ],
            [
                'company_name' => 'Cheema Jaya Enterprise',
                'name' => 'Bilal',
                'phone' => fake()->phoneNumber(), // random phone
            ],
            [
                'company_name' => 'PBS Outsource',
                'name' => 'Faisal',
                'phone' => fake()->phoneNumber(), // random phone
            ],
        ];

        Contractor::insert($data);
    }
}
