<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('profile_picture')->nullable();
            $table->text('street')->nullable();
            $table->string('street_number')->nullable();
            $table->string('city')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
                $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('state_id')->nullable();
                $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade')->onUpdate('cascade');
            $table->string('zipcode')->nullable();
            $table->string('timezone')->nullable();
            $table->text('contacts')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
