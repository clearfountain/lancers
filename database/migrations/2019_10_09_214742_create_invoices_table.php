<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('estimate_id');
                $table->foreign('estimate_id')->references('id')->on('estimates')->onDelete('cascade')->onUpdate('cascade');
            $table->date('issue_date')->nullable();
            $table->date('due_date')->nullable();
            $table->float('amount', 15, 2);
            $table->float('amount_paid', 15, 2)->default(0);
            $table->unsignedBigInteger('currency_id')->default(1);
                $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
            $table->string('filename')->nullable();
            $table->string('logo')->default('default-logo.png');
            $table->enum('status', ['unpaid', 'paid']);
            $table->timestamps();
            $table->string('invoice_color')->default('#0ABAB5');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('invoices');
    }

}
