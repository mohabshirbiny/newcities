<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->unsignedBigInteger("city_id")->nullable();
            $table->unsignedBigInteger("compound_id")->nullable();
            $table->unsignedBigInteger("developer_id")->nullable();
            $table->unsignedBigInteger("property_type_id")->nullable();
            $table->text("attachments");
            $table->text("cover");
            $table->text("gallery");
            $table->text("about");
            $table->boolean("use_facilities")->default(false);
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
        Schema::dropIfExists('properties');
    }
}
