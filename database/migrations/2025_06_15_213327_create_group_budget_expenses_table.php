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
        Schema::create('group_budget_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_budget_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // Bijv. "Jeugddag lunch"
            $table->decimal('amount', 10, 2);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_budget_expenses');
    }
};
