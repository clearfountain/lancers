<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimatesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('estimates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('time');
            $table->unsignedBigInteger('currency_id')->default(1);
                $table->foreign('currency_id')->references('id')->on('currencies');
            $table->integer('price_per_hour')->default(2000);
            $table->integer('equipment_cost')->nullable();
            $table->text('sub_contractors')->nullable();
            $table->integer('sub_contractors_cost')->nullable();
            $table->integer('similar_projects')->default(0);
            $table->integer('rating')->default(0);
            $table->float('estimate', 15, 2);
            $table->date('start');
            $table->date('end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('estimates');
    }

}
