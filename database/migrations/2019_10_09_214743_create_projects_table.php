<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users') ->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('client_id')->nullable();
                $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('estimate_id')->nullable();
                $table->foreign('estimate_id')->references('id')->on('estimates')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('invoice_id')->nullable();
                $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('tracking_code');
            $table->integer('progress')->default(0)->nullable();
            $table->enum('status', ['pending', 'in-progress', 'completed']);
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
        Schema::dropIfExists('projects');
    }
}
