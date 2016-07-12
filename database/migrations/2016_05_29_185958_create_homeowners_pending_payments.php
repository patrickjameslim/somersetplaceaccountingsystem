<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeownersPendingPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create home_owner_invoice_items Table in DB if it doesn't exist
        if(!Schema::hasTable('home_owner_invoice_items')){
            Schema::create('home_owner_invoice_items', function (Blueprint $table) {
                $table->increments('id');
                $table->Integer('invoice_id')->unsigned();
                $table->foreign('invoice_id')->references('id')->on('home_owner_invoice');
                $table->Integer('created_by')->unsigned();
                $table->foreign('created_by')->references('id')->on('users');
                $table->Integer('updated_by')->unsigned();
                $table->foreign('updated_by')->references('id')->on('users');
                $table->Integer('account_title_id')->unsigned();
                $table->foreign('account_title_id')->references('id')->on('account_titles');
                $table->decimal('amount',10,2)->default(0.00);
                $table->boolean('is_paid');
                $table->longText('remarks');
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
        //Drop Table of home_owner_invoice_items if exist
        Schema::dropIfExists('home_owner_invoice_items');
    }
}
