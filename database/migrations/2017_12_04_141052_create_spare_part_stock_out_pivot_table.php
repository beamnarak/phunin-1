<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSparePartStockOutPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_part_stock_out', function (Blueprint $table) {
            $table->integer('spare_part_id')->unsigned()->index();
            $table->foreign('spare_part_id')->references('id')->on('spare_parts')->onDelete('cascade');
            $table->integer('stock_out_id')->unsigned()->index();
            $table->foreign('stock_out_id')->references('id')->on('stock_outs')->onDelete('cascade');
            $table->primary(['spare_part_id', 'stock_out_id']);

            $table->decimal('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('spare_part_stock_out');
    }
}
