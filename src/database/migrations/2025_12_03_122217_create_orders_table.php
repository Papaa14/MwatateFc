<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Assuming customer_id links to your users table
            $table->unsignedBigInteger('customer_id');
            // Storing the product name or ID
            $table->string('product');
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->timestamps();

            // Optional: Add foreign key constraint if customer exists in users table
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
