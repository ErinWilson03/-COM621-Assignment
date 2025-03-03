<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            // Applicant details
            $table->string('name');
            $table->string('email');
            $table->string('mobile_number');
            $table->text('supporting_statement')->nullable();
            $table->string('cv_path')->nullable();

            // Foreign key for vacancy
            $table->string('vacancy_reference');
            $table->foreign('vacancy_reference')
                  ->references('reference_number')
                  ->on('vacancies')
                  ->onDelete('cascade');
            // Foreign key for user (applicant)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
