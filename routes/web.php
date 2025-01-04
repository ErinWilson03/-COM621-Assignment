<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\VacancyController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// User auth routes
Route::post("/logout", [UserController::class, "logout"])
    ->middleware('auth')->name("logout");

Route::middleware('guest')->group(function () {
    Route::get("/register", [UserController::class, "create"])->name("register");
    Route::post("/register", [UserController::class, "store"])->name("register.store");
    Route::get("/login", [UserController::class, "login"])->name("login");
    Route::post("/login", [UserController::class, "authenticate"])->name("login.authenticate");
});

// Vacancy Routes
Route::get('/vacancies', [VacancyController::class, "index"])->name("vacancies.index");
Route::get('/vacancies/create', [VacancyController::class, 'create'])->name('vacancies.create');
Route::get('/vacancies/{reference_number}', [VacancyController::class, 'show'])->name('vacancies.show');
Route::get('/vacancies/{reference_number}/edit', [VacancyController::class, 'edit'])->name('vacancies.edit');
Route::post('/vacancies', [VacancyController::class, 'store'])->name('vacancies.store');
Route::put('/vacancies/{reference_number}', [VacancyController::class, 'update'])->name('vacancies.update');
Route::delete('/vacancies/{reference_number}', [VacancyController::class, 'destroy'])->name('vacancies.destroy');

// Application Routes
Route::get('/applications/apply/{reference_number}', [ApplicationController::class, 'apply'])->name('applications.apply'); 
Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
Route::get('/applications/{id}', [ApplicationController::class, 'show'])->name('applications.show');
Route::get('/applications/{id}/edit', [ApplicationController::class, 'edit'])->name('applications.edit');
Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
Route::put('/applications/{id}', [ApplicationController::class, 'update'])->name('applications.update');
Route::delete('/applications/{id}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
