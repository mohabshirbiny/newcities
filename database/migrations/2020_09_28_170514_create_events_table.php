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
            $table->string("name");
            $table->date("date_from");
            $table->date("date_to");
            $table->time("time_from");
            $table->time("time_to");
            $table->text("contact_details")->nullable();
            $table->text("social_links")->nullable();
            $table->text("location_url");            
            $table->string("city_location")->nullable();
            $table->string("cover");
            $table->text("gallery")->nullable();
            $table->text("about");
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
