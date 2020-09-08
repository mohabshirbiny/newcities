<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('article_category_id');
            $table->foreign('article_category_id')->references('id')->on('article_categories');
            $table->string("title_en");
            $table->string("title_ar");
            $table->string("image");
            $table->string("brief_en");
            $table->string("brief_ar");
            $table->unsignedBigInteger("city_id");
            $table->string("body_en");
            $table->string("body_ar");
            $table->string("author");
            $table->string("vendor");
            $table->string("compound");
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
        Schema::dropIfExists('articles');
    }
}
