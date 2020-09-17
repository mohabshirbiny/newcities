<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('mobile')->unique();
            $table->string('email')->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('device_id')->nullable();
            $table->integer('status')->default(0)->index();
            $table->string('verification_code'); // verification code
            $table->integer('verification_code_sent')->default(0)->index(); // time stamp of verification sms
            $table->integer('last_notification_id')->default(0);
            $table->string('job_title')->nullable();
            $table->string('image')->nullable();
            $table->string('cv_url')->nullable();
            $table->string('location_governorate')->nullable();
            $table->string('location_city')->nullable();
            $table->text('about')->nullable();
            $table->string('remember_token')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
