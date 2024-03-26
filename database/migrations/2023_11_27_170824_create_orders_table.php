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
            $table->unsignedBigInteger('party_id')->nullable();
            $table->unsignedBigInteger('order_by')->nullable();
            $table->date('order_date')->nullable();
            $table->date('estimated_delivery_date')->nullable();
            $table->integer('boxes')->nullable();
            $table->double('net_weight', 10, 2)->nullable();
            $table->enum('order_status', [
                'pending', 'in_process', 'partially_delivered', 'delivered'
            ]);
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
