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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('external_reference')->unique(); // Order ID 123
            $table->string('lipia_reference')->nullable(); // The TransactionReference from Lipia
            $table->string('phone_number');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('PENDING'); // PENDING, SUCCESS, FAILED
            $table->string('receipt_number')->nullable(); // Mpesa Receipt
            $table->text('metadata')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
