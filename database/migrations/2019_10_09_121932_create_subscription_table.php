<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('plan_id');
                $table->foreign('plan_id')->references('id')->on('subscription_plans');
            $table->unsignedBigInteger('authorization_id')->nullable();
                $table->foreign('authorization_id')->references('id')->on('authorizations');
            $table->date('startdate');
            $table->date('enddate');
            $table->boolean('auto_renew')->default(true);
            $table->boolean('expired')->default(false);
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
        Schema::dropIfExists('Subscription');
    }
}
