<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveRepairmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_ins', function (Blueprint $table) {
            Schema::dropIfExists('repairments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('repairments', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('machine_id');
            $table->integer('shop_id');
            $table->integer('employee_id');
            $table->integer('user_id');

            $table->timestamps();
        });
    }
}
