<?php

use App\Models\Project;
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
        Schema::create('project_based_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::class);
            $table->integer('total_amount');
            $table->text('note')->nullable();
            $table->date('payment_date')->nullable();
            $table->unsignedBigInteger('paid_by');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_based_expenses');
    }
};
