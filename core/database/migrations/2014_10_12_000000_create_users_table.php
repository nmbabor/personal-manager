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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile_no')->unique();
            $table->unsignedBigInteger('country_id');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('type')->default('User');
            $table->string('username')->unique();
            $table->string('profile_image')->nullable();
            $table->string('google_id')->nullable();
            $table->boolean('is_google_registered')->default(false);
            $table->boolean('is_suspended')->default(false);
            $table->integer('monthly_amount')->default(500);
            $table->string('designation')->default('Member');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->tinyInteger('word_no')->default(6);
            $table->string('permanent_address')->nullable();
            $table->string('peresent_address')->nullable();
            $table->date('join_date');
            $table->date('deposit_start_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
