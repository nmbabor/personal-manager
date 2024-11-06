<?php

use App\Models\User;
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
        Schema::create('amount_depositeds', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->integer('amount');
            $table->tinyInteger('is_withdrawn')->default(0);
            $table->date('transaction_date')->nullable();
            $table->enum('type', ['collector', 'loan', 'unofficial'])->default('collector');
            $table->string('reference',255)->nullable();
            $table->string('details',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amount_depositeds');
    }
};
