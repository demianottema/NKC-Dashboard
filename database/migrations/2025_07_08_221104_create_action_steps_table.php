<?php

use App\Models\User;
use App\Models\ActionStep;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        Schema::create('action_steps', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('deadline');
            $table->timestamps();
        });

        Schema::create('action_step_users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ActionStep::class);
            $table->foreignIdFor(User::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_steps');
    }
};
