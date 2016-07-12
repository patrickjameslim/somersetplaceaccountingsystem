<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalEntry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('journal_entry')){
            Schema::create('journal_entry', function (Blueprint $table) {
                $table->increments('id');
                $table->Integer('created_by')->unsigned();
                $table->foreign('created_by')->references('id')->on('users');
                $table->Integer('updated_by')->unsigned();
                $table->foreign('updated_by')->references('id')->on('users');
                $table->Integer('invoice_id')->unsigned()->nullable();
                $table->foreign('invoice_id')->references('id')->on('home_owner_invoice');
                $table->Integer('receipt_id')->unsigned()->nullable();
                $table->foreign('receipt_id')->references('id')->on('home_owner_payment_transaction');
                $table->Integer('expense_id')->unsigned()->nullable();
                $table->foreign('expense_id')->references('id')->on('expense_cash_voucher');
                $table->String('type',255);
                $table->string('description',255)->default('No Description');
                $table->Integer('debit_title_id')->unsigned();
                $table->foreign('debit_title_id')->references('id')->on('account_titles');
                $table->Integer('credit_title_id')->unsigned();
                $table->foreign('credit_title_id')->references('id')->on('account_titles');
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
        //
    }
}
