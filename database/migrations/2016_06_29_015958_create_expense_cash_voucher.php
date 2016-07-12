<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseCashVoucher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('expense_cash_voucher')){
            Schema::create('expense_cash_voucher', function (Blueprint $table) {
                $table->increments('id');
                $table->Integer('created_by')->unsigned();
                $table->foreign('created_by')->references('id')->on('users');
                $table->Integer('updated_by')->unsigned();
                $table->foreign('updated_by')->references('id')->on('users');
                // $table->Integer('account_type_id')->unsigned();
                // $table->foreign('account_type_id')->references('id')->on('account_details');
                $table->string('paid_to',255);
                $table->decimal('total_amount',10,2)->default(0.00);
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
        Schema::dropIfExists('expense_cash_voucher');
    }
}
