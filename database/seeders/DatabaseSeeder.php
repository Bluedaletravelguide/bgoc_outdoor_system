<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            SuperAdminSeeder::class,
            PermissionSeeder::class,
            ServiceRequestCategorySeeder::class,
            ServiceRequestSubCategorySeeder::class,
            v02_serviceRequest::class,
            // v05_assetsSeeder::class,
            WorkOrdersSeeder::class
        ]);
    }
}
