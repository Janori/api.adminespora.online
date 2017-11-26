<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('customers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('name');
            $table->string('first_surname', 30)->nullable();
            $table->string('last_surname', 30)->nullable();
            $table->char('gender', 1)->default('x');
            $table->char('mariage_status', 1)->default('x');
            $table->char('kind', 1)->default('x');
            $table->timestamps();

            $table->string('calle', 80)->nullable();
            $table->string('colonia', 30)->nullable();
            $table->string('cp', 10)->nullable();
            $table->string('municipio', 30)->nullable();
            $table->string('estado', 30)->nullable();
            $table->string('pais', 30)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('customers');
    }
}
