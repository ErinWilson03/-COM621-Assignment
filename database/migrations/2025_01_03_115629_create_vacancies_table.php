<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\VacancyTypeEnum;
use App\Enums\IndustryEnum;
use App\Enums\LocationEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            
            // Company Information
            $table->foreignId('company_id')->constrained()->onDelete('cascade');

            //Vacancy Information
            $table->string('title', 100);
            $table->string('description', 500)->nullable();
            $table->text('skills_required')->nullable();
            $table->dateTime('application_open_date')->nullable();
            $table->dateTime('application_close_date')->nullable();    
            $table->decimal('salary', 10, 2)->nullable();
            $table->enum('location', array_column(LocationEnum::cases(), 'value'))->nullable();
            $table->enum('industry', array_column(IndustryEnum::cases(), 'value'))->nullable();
            $table->enum('vacancy_type', array_column(VacancyTypeEnum::cases(), 'value'))->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancies');
    }
};
