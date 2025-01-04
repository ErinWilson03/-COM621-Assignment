<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Vacancy;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VacancyTest extends TestCase
{
    use RefreshDatabase;

    public function test_vacancy_is_successfully_created_with_valid_data(): void
    {
        // Create a company to associate with the vacancy
        $company = Company::factory()->create();

        // Prepare valid vacancy data
        $vacancyData = [
            'title' => 'Software Developer',
            'company_id' => $company->id,
            'description' => 'Develop high-quality software.',
            'skills_required' => 'PHP, Laravel, MySQL',
            'application_open_date' => now()->addDay()->toDateString(),
            'application_close_date' => now()->addDays(10)->toDateString(),
            'location' => 'Remote',
            'salary' => 60000,
            'industry' => 'Technology',
            'vacancy_type' => 'Full-Time',
        ];

        // Simulate a POST request to the store route
        $response = $this->post(route('vacancies.store'), $vacancyData);

        // Assert response redirects to index with success message
        $response->assertRedirect(route('vacancies.index'));
        $response->assertSessionHas('success', 'Vacancy created successfully!');

        // Assert vacancy exists in the database
        $this->assertDatabaseHas('vacancies', [
            'title' => 'Software Developer',
            'company_id' => $company->id,
        ]);
    }

    public function test_validation_fails_when_title_is_missing(): void
    {
        // Create a company to associate with the vacancy
        $company = Company::factory()->create();

        // Prepare vacancy data without title
        $vacancyData = [
            'company_id' => $company->id,
            'description' => 'Develop high-quality software.',
            'skills_required' => 'PHP, Laravel, MySQL',
            'application_open_date' => now()->addDay()->toDateString(),
            'application_close_date' => now()->addDays(10)->toDateString(),
            'location' => 'Remote',
            'salary' => 60000,
            'industry' => 'Technology',
            'vacancy_type' => 'Full-Time',
        ];

        // Simulate a POST request to the store route
        $response = $this->post(route('vacancies.store'), $vacancyData);

        // Assert the validation fails
        $response->assertSessionHasErrors(['title' => 'The title field is required.']);

        // Assert no vacancy is created
        $this->assertDatabaseCount('vacancies', 0);
    }
}

