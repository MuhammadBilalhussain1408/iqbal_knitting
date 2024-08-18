<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsFromOrderOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_outs', function (Blueprint $table) {
            $table->dropColumn('total_boxes');
            $table->dropColumn('total_net_weight');
            $table->dropColumn('total_out_weight');
            $table->dropColumn('total_wastage');
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_outs', function (Blueprint $table) {
            $table->integer('total_boxes')->nullable();
            $table->double('total_net_weight', 10, 2)->nullable();
            $table->double('total_out_weight', 10, 2)->nullable();
            $table->double('total_wastage', 10, 2)->nullable();
            $table->string('status')->nullable();
        });
    }
}
