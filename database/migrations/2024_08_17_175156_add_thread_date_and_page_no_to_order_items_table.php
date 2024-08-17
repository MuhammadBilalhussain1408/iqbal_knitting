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
        Schema::table('order_items', function (Blueprint $table) {
            $table->date('thread_date')->nullable()->after('num_of_boxes'); // Replace 'existing_column' with the name of the column after which you want to add the new column
            $table->string('page_no')->nullable()->after('thread_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['thread_date', 'page_no']);
        });
    }
};
