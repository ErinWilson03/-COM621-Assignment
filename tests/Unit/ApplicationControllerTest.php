<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Application;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApplicationControllerTest extends TestCase
{
    use RefreshDatabase;

    // Find and return application
    public function test_findApplication_whenExists_returnsApplication(): void
    {
        $model = Application::factory()->make();
        $application = Application::create($model->toArray());

        // Using the controller route to find the application
        $response = $this->get(route('applications.show', $application->id));

        $response->assertStatus(200); // HTTP OK
    }

    /*
    * Testing my custom helper methods
    */
    public function test_getApplicationsForUser_returns_correct_applications()
    {
        // Create a user and their applications
        $user = User::factory()->create();
        Application::factory()->count(3)->create(['user_id' => $user->id]);

        // Create applications for another user
        Application::factory()->count(2)->create();

        // Mock the controller
        $controller = app(\App\Http\Controllers\ApplicationController::class);

        // Retrieve applications for the user
        $query = Application::query();
        $result = $controller->getApplicationsForUser($user, $query);

        // Assert only the correct applications are returned
        $this->assertCount(3, $result);
        foreach ($result as $application) {
            $this->assertEquals($user->id, $application->user_id);
        }
    }

    public function test_getApplicationsForUser_fails_for_different_user()
    {
        // Create two users
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        // Create applications for the other user
        Application::factory()->count(2)->create(['user_id' => $otherUser->id]);

        // Mock the controller
        $controller = app(\App\Http\Controllers\ApplicationController::class);

        // Retrieve applications for the user
        $query = Application::query();
        $result = $controller->getApplicationsForUser($user, $query);

        // Assert no applications are returned
        $this->assertCount(0, $result);
    }
}
