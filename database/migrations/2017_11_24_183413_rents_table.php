<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('rents', function (Blueprint $table) {
          $table->engine = 'InnoDB';
          $table->charset = 'utf8';
          $table->collation = 'utf8_general_ci';
          $table->increments('id');
          $table->integer('renter_id')->unsigned()->nullable();
          $table->integer('building_id')->unsigned()->nullable();


          $table->string('extra_data');
          $table->timestamps();

          $table->decimal('price', 12, 2);
          $table->integer('rent_period');

          $table->decimal('mantainance_cost', 12, 2);
          $table->char('mantainance_period')->default('m');
          $table->float('commission_percent');
          $table->integer('deposits_number');

          $table->foreign('renter_id')->references('id')->on('rents')->onDelete('cascade');
          $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rents');
    }
}
