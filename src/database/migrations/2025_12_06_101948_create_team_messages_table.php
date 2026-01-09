<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('team_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id')->nullable(); // Coach ID
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->string('recipient_group')->nullable(); // 'all', 'squad', 'reserves'
            $table->text('content');
            $table->integer('is_read')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_messages');
    }
};
