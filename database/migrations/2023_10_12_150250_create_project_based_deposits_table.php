<?php

use App\Models\Project;
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
        Schema::create('project_based_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Project::class);
            $table->integer('paid_amount');
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
        Schema::dropIfExists('project_based_deposits');
    }
};
