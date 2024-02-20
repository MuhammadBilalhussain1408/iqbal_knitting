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
        Schema::create('order_out_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_out_id')->nullable();
            $table->unsignedBigInteger('thread_id')->nullable();
            $table->unsignedBigInteger('num_of_boxes')->nullable();
            $table->double('total_weight',10,2)->nullable();
            $table->integer('deliver_boxes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_out_items');
    }
};
