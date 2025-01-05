<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\IndustryEnum;

class VacancyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_filterVacancies_returns_filtered_results()
    {
        // Create vacancies
        Vacancy::factory()->count(3)->create(['industry' => IndustryEnum::Technology->value]);
        Vacancy::factory()->count(2)->create(['industry' => IndustryEnum::Healthcare->value]);

        // Mock the controller
        $controller = app(\App\Http\Controllers\VacancyController::class);

        // Apply a filter for "Technology"
        $filters = ['industry' => IndustryEnum::Technology->value];
        $result = $controller->filterVacancies($filters)->get();

        // Assert the correct count and industry enum
        $this->assertCount(3, $result);
        foreach ($result as $vacancy) {
            $this->assertEquals(IndustryEnum::Technology, $vacancy->industry);
        }
    }

    public function test_filterVacancies_fails_for_incorrect_filter()
    {
        // Create vacancies with healthcare industry
        Vacancy::factory()->count(2)->create(['industry' => IndustryEnum::Healthcare->value]);

        // Mock the controller
        $controller = app(\App\Http\Controllers\VacancyController::class);

        // Apply a filter for "Finance" (no vacancies were created with this industry)
        $filters = ['industry' => 'Finance'];
        $result = $controller->filterVacancies($filters)->get();

        // Assert no results are returned
        $this->assertCount(0, $result);
    }
}
