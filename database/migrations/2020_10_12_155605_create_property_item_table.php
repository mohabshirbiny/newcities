<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("property_id");
            $table->unsignedBigInteger("property_item_id");
            $table->integer("count_of_items");
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
        Schema::dropIfExists('property_item');
    }
}
