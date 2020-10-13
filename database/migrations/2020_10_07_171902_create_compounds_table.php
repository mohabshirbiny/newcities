<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compounds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->string("logo");
            $table->text("location_url");
            $table->text("contact_details");
            $table->text("about");
            $table->text("cover");
            $table->text("social_media");
            $table->text("gallery")->nullable();
            $table->text("attachments")->nullable();
            $table->boolean("use_facilities")->default(false);
            $table->unsignedBigInteger("city_id")->nullable();
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
        Schema::dropIfExists('compounds');
    }
}
