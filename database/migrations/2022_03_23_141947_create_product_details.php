<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDetails extends Migration
{
    public function up()
    {
        
        Schema::create('Product_Details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('Id');
            $table->string('product_name');
            $table->string('description');
            $table->string('company_name');
            $table->string('offer');
            $table->integer('review')->default(0);
            $table->unsignedBigInteger('discount')->default(0);
            $table->unsignedBigInteger('price');
            $table->string('quantity');
            $table->string('image_path');
            $table->unsignedBigInteger('merchant_phone_number');
        });
        Schema::enableForeignKeyConstraints();
        Schema::table('Product_Details', function (Blueprint $table) {
            $table->foreign('merchant_phone_number')->references('phone_number')->on('User_Details')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ProductDetails');
    }
}
