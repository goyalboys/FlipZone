<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetails extends Migration
{
    public function up()

    {
        Schema::create('User_Details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('name');
            $table->string('email_id')->unique();
            $table->string('password');
            $table->string('gender');
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
        Schema::dropIfExists('UserDetails');
    }
}
