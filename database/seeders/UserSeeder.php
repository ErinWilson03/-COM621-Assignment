<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'role' => Role::ADMIN
        ]);

        // Creating Author users for each of the four seeded companies
        User::create([
            'name' => 'Tech Radar',
            'email' => 'tech@mail.com',
            'password' => Hash::make('password'),
            'role' => Role::AUTHOR,
            'company_id' => $this->getCompanyIdByName('Tech Radar')
        ]);

        User::create([
            'name' => 'Security Sloth',
            'email' => 'security@mail.com',
            'password' => Hash::make('password'),
            'role' => Role::AUTHOR,
            'company_id' => $this->getCompanyIdByName('Security Sloth')
        ]);

        User::create([
            'name' => 'AtlasWare',
            'email' => 'atlas@mail.com',
            'password' => Hash::make('password'),
            'role' => Role::AUTHOR,
            'company_id' => $this->getCompanyIdByName('AtlasWare')
        ]);

        User::create([
            'name' => "Foster's Finance",
            'email' => 'finance@mail.com',
            'password' => Hash::make('password'),
            'role' => Role::AUTHOR,
            'company_id' => $this->getCompanyIdByName("Foster's Finance")
        ]);

        // Creating a set Registered User for testing
        User::create([
            'name' => 'Jane Doe',
            'email' => 'janedoe@mail.com',
            'password' => Hash::make('password'),
            'role' => Role::USER
        ]);
    }

    // Helper method to get the company IDs
    private function getCompanyIdByName(string $companyName): int
    {
        $company = Company::where('name', $companyName)->first();
        return $company?->id;
    }
}
