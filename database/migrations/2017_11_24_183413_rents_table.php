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
          $table->integer('renter_id')->unsigned();
          $table->integer('user_id')->unsigned();
          $table->integer('building_id')->unsigned();

          $table->timestamps();

          $table->decimal('price', 12, 2);
          $table->integer('rent_period');

          $table->char('status')->default('p');

          // $table->decimal('mantainance_cost', 12, 2);
          // $table->char('mantainance_period')->default('m');
          // $table->float('commission_percent');
          // $table->integer('deposits_number');
          $table->dateTime('start_date')->nullable();
          $table->string('contract_path')->nullable();
          $table->string('extra_data')->nullable();

          $table->foreign('renter_id')->references('id')->on('customers')->onDelete('cascade');
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
