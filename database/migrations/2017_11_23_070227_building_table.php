<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuildingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('buildings', function (Blueprint $table) {
          $table->engine = 'InnoDB';
          $table->charset = 'utf8';
          $table->collation = 'utf8_general_ci';
          $table->increments('id');
          $table->integer('owner_id')->unsigned()->nullable();
          $table->integer('land_id')->unsigned()->nullable();
          $table->integer('warehouse_id')->unsigned()->nullable();
          $table->integer('office_id')->unsigned()->nullable();
          $table->integer('house_id')->unsigned()->nullable();

          $table->string('extra_data');
          $table->timestamps();

          $table->decimal('price', 12, 2);
          $table->decimal('maintenance_cost', 12, 2);
          $table->char('maintenance_period')->default('M');
          $table->float('com_percent');
          $table->integer('minimum_rent_period');
          $table->integer('deposit_number');

          $table->foreign('owner_id')->references('id')->on('customers')->onDelete('no action');
          $table->foreign('land_id')->references('id')->on('lands')->onDelete('cascade');
          $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
          $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
          $table->foreign('house_id')->references('id')->on('housings')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buildings');
    }
}
