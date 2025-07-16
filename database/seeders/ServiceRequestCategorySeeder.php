<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceRequestCategory;

class ServiceRequestCategorySeeder extends Seeder
{
    public function run()
    {
        // Define an array of service request categories
        $categories = [
            'ACI',
            'FinTech',
            'RND',
            'Cleaning',
            'Chiller System',
            'DMX Lighting System',
            'Others',
        ];

        // Loop through the categories and insert them into the database
        foreach ($categories as $category) {
            ServiceRequestCategory::create([
                'name' => $category,
            ]);
        }
    }
}


use App\Models\ServiceRequestSubCategory;

class ServiceRequestSubCategorySeeder extends Seeder
{
    public function run()
    {
        // JSON data representing the subcategories linked with category names
        // $data = '{
        //     "Lighting": ["Bulb Replacement", "Fixture Installation", "Dimmer Switch Repair", "Wiring Maintenance", "Emergency Lighting Inspection"],
        //     "Civil": ["Concrete Repairs", "Foundation Inspection", "Structural Reinforcement", "Masonry Work", "Sidewalk and Pavement Repair"],
        //     "Plumbing Systems": ["Leak Detection and Repair", "Drain Cleaning", "Toilet Maintenance", "Pipe Replacement", "Water Heater Installation"],
        //     "Cleaning": ["Janitorial Services", "Carpet Cleaning", "Window Washing", "Deep Cleaning", "Graffiti Removal"],
        //     "Carpentry": ["Furniture Assembly", "Door Installation/Repair", "Cabinetry Installation", "Trim and Molding Work", "Custom Woodwork"],
        //     "AC (Air Conditioning)": ["HVAC Maintenance", "AC Unit Installation", "Duct Cleaning", "Refrigerant Recharge", "Thermostat Replacement"],
        //     "Fire Alarm System": ["Fire Alarm Testing", "System Inspection", "False Alarm Troubleshooting", "Sensor Replacement", "Control Panel Upgrades"],
        //     "Pest Control": ["Rodent Extermination", "Termite Inspection and Treatment", "Bedbug Eradication", "Ant and Roach Control", "Bird Control"],
        //     "Landscaping": ["Lawn Mowing and Maintenance", "Tree Pruning and Trimming", "Garden Design and Installation", "Irrigation System Repair", "Hardscape Construction"],
        //     "Chiller System": ["Chiller Maintenance", "Chiller Efficiency Audit", "Refrigerant Leak Repair", "Chiller Overhaul", "Cooling Tower Cleaning"],
        //     "DMX Lighting System": ["DMX Controller Programming", "Fixture Addressing and Configuration", "LED Color Programming", "DMX Troubleshooting", "DMX Cable Replacement"],
        //     "Others": ["General Maintenance", "Emergency Repairs", "Safety Inspections", "Renovation Projects", "Miscellaneous Services"]
        // }';

        $data = '{
            "ACI": ["Switch Debug", "ICEXS Debug", "UPF - Installation", "APSF - Installation", "UPF - Configuration", "APSF - Configuration"],
            "FinTech": ["Testing", "System Debug", "Architecture", "Software Support", "Hardware Support"],
            "RND": ["IoT Support", "3D Printing", "System Debug", "Software Support", "Hardware Support"],
            "Cleaning": ["Janitorial Services", "Carpet Cleaning", "Window Washing", "Deep Cleaning", "Graffiti Removal"],
            "Chiller System": ["Chiller Maintenance", "Chiller Efficiency Audit", "Refrigerant Leak Repair", "Chiller Overhaul", "Cooling Tower Cleaning"],
            "DMX Lighting System": ["DMX Controller Programming", "Fixture Addressing and Configuration", "LED Color Programming", "DMX Troubleshooting", "DMX Cable Replacement"],
            "Others": ["General Maintenance", "Emergency Repairs", "Safety Inspections", "Renovation Projects", "Miscellaneous Services"]
        }';

        // Decode the JSON data
        $subcategoriesData = json_decode($data, true);

        // Loop through the categories and their subcategories and insert them into the database
        foreach ($subcategoriesData as $categoryName => $subcategories) {
            // Get the category ID based on the category name
            $categoryId = ServiceRequestCategory::where('name', $categoryName)->value('id');
            
            if ($categoryId) {
                foreach ($subcategories as $subcategoryName) {
                    ServiceRequestSubCategory::create([
                        'name' => $subcategoryName,
                        'sr_category_id' => $categoryId,
                    ]);
                }
            }
        }
    }
}
