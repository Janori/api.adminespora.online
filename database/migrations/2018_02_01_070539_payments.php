<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Payments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('payments', function (Blueprint $table) {
          $table->engine = 'InnoDB';
          $table->charset = 'utf8';
          $table->collation = 'utf8_general_ci';

          $table->increments('id');
          $table->timestamps();

          $table->integer('charge_to')->unsigned();
          $table->integer('pay_to')->unsigned();
          $table->integer('building_id')->unsigned()->nullable();
          $table->integer('ticket_id')->unsigned()->nullable();

          $table->decimal('charge', 12, 2);
          $table->decimal('charge_payment', 12, 2);
          $table->decimal('paying', 12, 2);
          $table->decimal('paying_payment', 12, 2);
          $table->dateTime('due_date');

          $table->boolean('paid_out')->default(false);
          $table->boolean('facturable')->default(false);
          $table->char('kind', 1)->default('x'); //r -> Rent | x -> undefined | t -> ticket |

          $table->foreign('charge_to')->references('id')->on('customers')->onDelete('cascade');
          $table->foreign('pay_to')->references('id')->on('customers')->onDelete('cascade');
          $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
          $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('payments');
    }
}
