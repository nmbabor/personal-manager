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
        Schema::create('yearly_closing_amounts', function (Blueprint $table) {
            $table->id();
            $table->integer('closing_amount');
            $table->integer('closing_year');
            $table->date('closing_date');
            $table->unsignedBigInteger('closed_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yearly_closing_amounts');
    }
};
