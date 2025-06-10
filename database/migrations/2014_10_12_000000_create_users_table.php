<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'employer', 'jobseeker'])->default('jobseeker');
            $table->boolean('is_approved')->default(false);
            $table->string('company_name')->nullable();
            $table->text('company_description')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('resume_url')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}; 