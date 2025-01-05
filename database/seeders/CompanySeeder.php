<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Predefined companies
        Company::create([
            'name' => 'Tech Radar',
            'email' => 'contact@techradar.com',
            'phone_number' => '+1-800-555-TECH',
            'website' => 'https://www.techradar.com',
            'city' => 'Belfast',
            "logo" => 'company_logos\specific_logos\tech_radar.png'
        ]);

        Company::create([
            'name' => 'Security Sloth',
            'email' => 'support@securitysloth.com',
            'phone_number' => '+1-800-555-SAFE',
            'website' => 'https://www.securitysloth.com',
            'city' => 'Antrim',
            "logo" => "company_logos\specific_logos\security_sloth.png"
        ]);

        Company::create([
            'name' => 'AtlasWare',
            'email' => 'info@atlasware.com',
            'phone_number' => '+1-800-555-GEAR',
            'website' => 'https://www.atlasware.com',
            'city' => 'London',
            "logo" => "company_logos\specific_logos\atlasware.png"
        ]);

        Company::create([
            'name' => "Foster's Finance",
            'email' => 'finance@fosters.com',
            'phone_number' => '+1-800-555-MONEY',
            'website' => 'https://www.fostersfinance.com',
            'city' => 'Derry',
            "logo" => 'company_logos\specific_logos\fosters_finance.png'
        ]);

        Company::factory(10)->create();
    }
}
