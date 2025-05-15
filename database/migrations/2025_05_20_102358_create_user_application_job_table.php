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
        Schema::create('user_application_job', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('users');
            $table->foreignId('job_id')->constrained('jobs');
            $table->boolean('applicationStatus')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_application_job');
    }
};
