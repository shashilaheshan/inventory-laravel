<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerTransections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_transections', function (Blueprint $table) {
          $table->increments('id');
                $table->integer('customer_id');
                $table->string('invoice_id');
                $table->integer('total_purchase');
                $table->integer('amount_paid');
                $table->timestamps();

                $table->foreign('customer_id')->references('id')->on('customers');
                $table->foreign('invoice_id')->references('id')->on('invoices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_transections');
    }
}
