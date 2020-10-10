<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vendor_category_id');
            $table->foreign('vendor_category_id')->references('id')->on('vendor_categories');
            $table->string("name");
            $table->string("logo");
            $table->string("cover");
            $table->text("gallery")->nullable();
            $table->string("location_url");
            $table->string("about");
            $table->text("contact_details");
            $table->text("social_media");
            $table->unsignedBigInteger("city_id")->nullable();
            $table->unsignedBigInteger("district_id")->nullable();
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->boolean("is_parent")->default(false);
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
        Schema::dropIfExists('vendors');
    }
}
