<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text("title");
            $table->string("image");
            $table->string("date_from");
            $table->string("date_to");
            $table->text("brief");
            $table->text("body");
            $table->text("attachment");
            $table->text("book_value");
            $table->text("insurance_value");
            $table->text('gallery')->nullable();
            $table->unsignedBigInteger("city_id");

            $table->unsignedBigInteger('tender_category_id');
            $table->foreign('tender_category_id')->references('id')->on('tender_categories');
            
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
        Schema::dropIfExists('tenders');
    }
}
