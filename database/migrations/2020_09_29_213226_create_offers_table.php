<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->text("title");
            $table->text("description");
            $table->string("image");
            $table->string("price_before");
            $table->string("price_after");
            $table->string("order_tel_number");
            $table->string("expiration_date");
            $table->string("discount_percentage");
            $table->text("url");
        
            $table->unsignedBigInteger("vendor_id");
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger('offer_category_id');
            
            $table->foreign('offer_category_id')->references('id')->on('offer_categories');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
