<?php
// database/migrations/xxxx_xx_xx_create_training_plan_assignments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('training_plan_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_plan_id')->constrained()->onDelete('cascade');
            $table->foreignId('player_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('training_plan_assignments');
    }
};
