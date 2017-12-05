<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSparePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_parts', function (Blueprint $table) {
            $table->increments('id');

            $table->string('code')->unique();
            $table->mediumText('description')->nullable();
            $table->mediumText('note')->nullable();

            $table->decimal('minimum'); //minimum quantity in store
            $table->integer('category_id');
            $table->integer('unit_id');
            $table->integer('position_id');
            $table->integer('user_id');

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
        Schema::dropIfExists('spare_parts');
    }
}
