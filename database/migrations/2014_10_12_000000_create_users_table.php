<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('email')->nullable();
            $table->string('password', 60);
            $table->string('img_path')->nullable();

            $table->string('name');
            $table->string('first_surname', 30)->nullable();
            $table->string('last_surname', 30)->nullable();
            $table->char('gender', 1)->default('x');
            $table->char('kind', 1)->default('x');
            $table->timestamps();

            $table->integer('role_id')->unsigned()->nullable();
            $table->boolean('active')->default(true);

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
