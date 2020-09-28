<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("title_en");
            $table->string("title_ar");
            $table->date("date_from");
            $table->date("date_to");
            $table->time("time_from");
            $table->time("time_to");
            $table->text("contact_details")->nullable();
            $table->text("location_url");            
            $table->string("city_location")->nullable();
            $table->text("address");
            $table->string("cover");
            $table->text("gallery");
            $table->text("about_en");
            $table->text("about_ar");
            $table->unsignedBigInteger("city_id");
            $table->unsignedBigInteger("event_category_id")->nullable();
            $table->unsignedBigInteger("event_organizer_id")->nullable();
            $table->unsignedBigInteger("event_sponsor_id")->nullable();
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
        Schema::dropIfExists('events');
    }
}
