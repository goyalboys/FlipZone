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
        Schema::create('Users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('name');
            $table->string('email_id')->unique();
            $table->string('password');
            $table->string('gender');
            $table->string('address')->default("");
            $table->unsignedBigInteger('phone_number')->primary();
            $table->string('type_of_user');
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
