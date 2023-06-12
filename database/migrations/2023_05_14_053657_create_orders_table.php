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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('address_label');
            $table->string('name_user');
            $table->string('discount_name')->default("");
            $table->integer('phone');
            $table->integer('discount_value')->default(0);
            $table->integer('express');
            $table->integer('standard');
            $table->integer('total_price');



            $table->integer('status')->default(0)->comment('0-handle,1-transport,2-success');
            $table->boolean('status_payment')->default(false)->comment('1-user is payment,0-user is not payment');
            $table->string('payment_method')->comment('COD/Credit-card');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
