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
        Schema::create('employers', function (Blueprint $table)
        {


            $table->id();
            $table->string('company_name');
            $table->text('description')->nullable();
            $table->string('industry')->nullable();
            $table->string('logo_url')->nullable();
            $table->date('established_date')->nullable();
            $table->string('company_size')->nullable();
            $table->boolean('verified')->default(false);
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }
};
