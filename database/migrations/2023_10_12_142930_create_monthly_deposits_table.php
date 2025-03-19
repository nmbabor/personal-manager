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
        Schema::create('monthly_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->integer('payment_month');
            $table->integer('payment_year');
            $table->integer('payable_amount')->default(500);
            $table->integer('paid_amount')->nullable();
            $table->integer('is_paid')->default(0);
            $table->string('payment_gateway')->default('bKash');
            $table->string('reference_no')->nullable();
            $table->string('note')->nullable();
            $table->date('payment_date')->nullable();
            $table->unsignedBigInteger('received_by');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_deposits');
    }
};
