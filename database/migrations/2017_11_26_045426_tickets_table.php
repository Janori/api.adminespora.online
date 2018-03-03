<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');
            $table->integer('requester_id')->unsigned();
            $table->integer('agent_id')->unsigned();
            $table->integer('building_id')->unsigned();
            $table->integer('provider_id')->unsigned()->nullable();
            $table->string('data')->nullable();
            $table->decimal('provider_cost', 12, 2)->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->date('estimated_date')->nullable();
            $table->date('finalized_date')->nullable();
            $table->string('extra')->nullable();
            $table->char('status', 1)->default('o');
            $table->string('request_hash')->nullable();

            $table->timestamps();

            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('provider_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('requester_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
