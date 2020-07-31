<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepairmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('repairments', function (Blueprint $table) {
            $table->increments('id');

            $table->date('start_date');         // when it broke
            $table->date('end_date')->nullable();           // when it's fixed

            $table->integer('shop_id');         // who fix
            $table->integer('machine_id');      // fix what

            $table->decimal('wage_cost')->nullable();
            $table->decimal('travel_cost')->nullable();
            $table->decimal('accommodation_fee')->nullable();
            $table->decimal('spare_part_cost')->nullable();
            $table->decimal('delivery_cost')->nullable();
            $table->decimal('clearance_cost')->nullable();
           
            $table->mediumText('description')->nullable();
            $table->mediumText('payment_list')->nullable();

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
        Schema::dropIfExists('repairments');
    }
}
