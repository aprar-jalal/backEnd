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
        Schema::create('jobs', function (Blueprint $table)
        {

            $table->id('job_id');

            $table->foreignId('employer_id')->constrained('employers')->onDelete('cascade');

            $table->string('job_title');
            $table->text('description');
            $table->Json('job_full_disc');
            $table->string('location');
            $table->decimal('salary')->nullable();
            $table->string('job_type');
            $table->boolean('availability')->default(true);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
