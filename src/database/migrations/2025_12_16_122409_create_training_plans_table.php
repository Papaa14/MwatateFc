<?php
// database/migrations/xxxx_xx_xx_create_training_plans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('training_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->constrained('users')->onDelete('cascade');
            $table->string('subject');
            $table->string('type');
            $table->text('description');
            $table->string('video_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('training_plans');
    }
};
