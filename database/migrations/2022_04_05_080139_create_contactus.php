<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tickets', function (Blueprint $table) {
            $table->increments('contactId');
            $table->engine = 'InnoDB';
            $table->string('name')->default('');
            $table->string('phone')->default('');
            $table->string('subject');
            $table->string('problem');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Tickets');
    }
}
