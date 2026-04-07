<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('section_name')->nullable()->after('quantity');
            $table->json('seat_numbers')->nullable()->after('section_name');
            $table->foreignId('fixture_id')->nullable()->constrained()->onDelete('cascade')->after('seat_numbers');
            $table->string('ticket_type')->nullable()->after('fixture_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['section_name', 'seat_numbers', 'ticket_type']);
            $table->dropForeignKeyIfExists(['fixture_id']);
        });
    }
};
