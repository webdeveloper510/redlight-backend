<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('sms');
            $table->string('zip_code');
            $table->string('city');
            $table->string('height');
            $table->string('weight');
            $table->string('hair_color');
            $table->string('bust_size');
            $table->string('cup_size');
            $table->string('dress_size');
            $table->string('profile_claimed');
            $table->string('profile_id');           
            $table->string('advertisement_url1');
            $table->string('advertisement_url2');
            $table->string('advertisement_url3');
            $table->string('image1');
            $table->string('image2');
            $table->string('image3');
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
        Schema::dropIfExists('providers');
    }
}
