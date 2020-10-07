<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("title_en");
            $table->string("title_ar");
            $table->string("logo");
            $table->text("about_en");
            $table->text("about_ar");
            $table->text("cover");
            $table->text("gallery");
            $table->text("contact_details")->nullable();
            $table->text("location_url");   
            $table->unsignedBigInteger("service_category_id")->nullable();
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
        Schema::dropIfExists('services');
    }
}
