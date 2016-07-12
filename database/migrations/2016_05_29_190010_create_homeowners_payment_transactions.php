<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeownersPaymentTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create home_owner_payment_transaction Table in DB if it doesn't exist
        if(!Schema::hasTable('home_owner_payment_transaction')){
            Schema::create('home_owner_payment_transaction', function (Blueprint $table) {
                $table->increments('id');
                $table->Integer('payment_id')->unsigned();
                $table->foreign('payment_id')->references('id')->on('home_owner_invoice');
                $table->Integer('created_by')->unsigned();
                $table->foreign('created_by')->references('id')->on('users');
                $table->Integer('updated_by')->unsigned();
                $table->foreign('updated_by')->references('id')->on('users');
                $table->binary('file_related');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Drop Table of home_owner_payment_transaction if exist
        Schema::dropIfExists('home_owner_payment_transaction');
    }
}
