<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->text("contact_details");
            $table->string("logo");
            $table->text("location_url");
            $table->text("about");
            $table->text("cover");
            $table->text("gallery");
            $table->text("social_media");
            $table->unsignedBigInteger("contractor_category_id")->nullable();
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
        Schema::dropIfExists('contractors');
    }
}
