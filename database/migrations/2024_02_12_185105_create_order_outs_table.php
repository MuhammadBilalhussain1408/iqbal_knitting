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
        Schema::create('order_outs', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable();
            $table->integer('party_id')->nullable();
            $table->integer('total_boxes')->nullable();
            $table->integer('total_net_weight')->nullable();
            $table->text('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_outs');
    }
};
