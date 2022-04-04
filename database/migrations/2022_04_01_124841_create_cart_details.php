<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Cart_Details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('cartId');
            $table->unsignedBigInteger('customercart_phone');
            $table->unsignedInteger('product_id');
            $table->integer('quantity')->unsigned();
            });
            Schema::enableForeignKeyConstraints();
            Schema::table('Cart_Details', function (Blueprint $table) {
                $table->foreign('customercart_phone')->references('phone_number')->on('User_Details')->onDelete('cascade');
                $table->foreign('product_id')->references('Id')->on('Product_Details')->onDelete('cascade');
                });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CartDetails');
    }
}
