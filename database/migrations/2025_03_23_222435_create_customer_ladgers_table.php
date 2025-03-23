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
        Schema::create('customer_ladgers', function (Blueprint $table) {
            $table->id();
            $table->date('date')->default(now());
            $table->integer('amount');
            $table->enum('type', ['due', 'deposit']);
            $table->text('details')->nullable();
            $table->foreignId('customer_due_book_id')->constrained('customer_due_books');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_ladgers');
    }
};
