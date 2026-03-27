<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fixtures', function (Blueprint $table) {
            $table->foreignId('stadium_id')->nullable()->constrained('stadiums')->onDelete('set null');
            $table->integer('ticket_capacity')->nullable();
            $table->integer('tickets_sold')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('fixtures', function (Blueprint $table) {
            $table->dropForeign(['stadium_id']);
            $table->dropColumn(['stadium_id', 'ticket_capacity', 'tickets_sold']);
        });
    }
};
