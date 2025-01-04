<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Vacancy;
use App\Models\User;
use App\Models\Application;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Company must be seeded before Users
        $this->call(CompanySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(VacancySeeder::class);
        $this->call(ApplicationSeeder::class);

        // create some more random companies, vacancies, users and applications
        Company::factory(5)->create();
        Vacancy::factory(10)->create();
        User::factory(10)->create();
        Application::factory(10)->create();

        // Predefined vacancy references
        $vacancyReferences = ['VAC-812345', 'VAC-867890', 'VAC-856789'];

        // Create randoom applications for each of these references
        foreach ($vacancyReferences as $vacancyReference) {
            $vacancy = Vacancy::where('reference_number', $vacancyReference)->first();

            if ($vacancy) {
                for ($i = 0; $i < 5; $i++) {
                    Application::factory()->create([
                        'vacancy_reference' => $vacancy->reference_number,
                    ]);
                }
            }
        }
    }
}
