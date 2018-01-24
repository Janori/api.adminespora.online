<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
      Schema::create('lands', function (Blueprint $table) {
          $table->engine = 'InnoDB';
          $table->charset = 'utf8';
          $table->collation = 'utf8_general_ci';
          $table->increments('id');
          // $table->boolean('for_sale');
          $table->string('location');
          //$table->decimal('price', 12, 2);
          $table->float('surface');
          $table->decimal('predial_cost', 12,2);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lands');
    }
}
