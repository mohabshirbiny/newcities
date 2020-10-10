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
            $table->string("name");
            $table->string("logo");
            $table->text("about");
            $table->text("cover");
            $table->text("gallery")->nullable();
            $table->text("contact_details")->nullable();
            $table->text("location_url");
            $table->text("social_media");
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
