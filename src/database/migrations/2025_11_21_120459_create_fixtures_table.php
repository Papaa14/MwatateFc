<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->string('opponent');
            $table->dateTime('match_date');
            $table->enum('venue', ['Home', 'Away']);
            $table->string('competition'); // e.g., League, Cup, Friendly
            $table->integer('home_score')->nullable();
            $table->integer('away_score')->nullable();
            $table->enum('status', ['scheduled', 'live', 'fulltime'])->default('scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
