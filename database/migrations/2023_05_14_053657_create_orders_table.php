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
            $table->string('address');
            $table->string('name');
            $table->string('city');
            $table->string('province');
            $table->integer('phone');
            $table->integer('express');
            $table->integer('standard');
            $table->integer('total_price');
            $table->integer('discount_id')->nullable();
            $table->integer('status')->default(0)->comment('0-handle,1-transport,2-success');
            $table->boolean('status_payment')->default(false);
            $table->string('payment_method')->comment('1-success,0-unsuccess');
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
