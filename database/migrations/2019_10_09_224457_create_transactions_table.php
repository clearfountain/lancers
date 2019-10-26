<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->unsigned()->index('user_id');
                $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('subscription_id')->unsigned();
                $table->foreign('subscription_id')->references('id')->on('subscriptions');
            $table->decimal('amount', 20, 2)->comment('Amount of money that was credited or debited');
            $table->text('narration')->nullable();
            $table->string('country')->nullable();
            $table->string('currency')->nullable();
            $table->string('reference')->unique('reference')->nullable();
            $table->enum('status', ['pending', 'succesful', 'failed']);
            $table->string('channel')->nullable()->comment('bank transfer, or instant credit/debit card, or a saved debit/credit card');
            $table->string('ip_address')->nullable(); //use the correct ip address type
            $table->string('site_referrer')->nullable();
            $table->string('attempts')->nullable();
            $table->string('fees')->nullable();
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
