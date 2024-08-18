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
        Schema::table('order_out_items', function (Blueprint $table) {
            $table->integer('num_of_rolls')->nullable()->after('quality_date');
            $table->double('total_weight', 10, 2)->nullable()->after('num_of_rolls');
            $table->integer('quality_id')->nullable()->after('total_weight');
            $table->string('page_no')->nullable()->after('quality_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_out_items', function (Blueprint $table) {
            $table->dropColumn(['num_of_rolls', 'total_weight', 'quality_id', 'page_no']);

        });
    }
};
