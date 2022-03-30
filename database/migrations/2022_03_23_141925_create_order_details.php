<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetails extends Migration
{
    public function up()
    {
        Schema::create('Order_Details', function (Blueprint $table) {
        $table->engine = 'InnoDB';
        $table->increments('orderId');
        $table->unsignedBigInteger('customer_phone');
        $table->integer('review')->default(0);
        $table->timestamp('added_on');

        });
        Schema::enableForeignKeyConstraints();
        Schema::table('Order_Details', function (Blueprint $table) {
            $table->foreign('customer_phone')->references('phone_number')->on('User_Details')->onDelete('cascade');
    
            });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('OrdertDetails');
    }
}
