<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('account_details')){
            // Schema::create('account_details', function (Blueprint $table) {
            //     $table->increments('id');
            //     $table->string('account_name',255)->unique();
            //     $table->timestamp('accounting_year_start_date');
            //     $table->timestamp('accounting_year_end_date');
            //     $table->decimal('o_p_balance',10,2);
            //     $table->decimal('c_l_balance',10,2)->nullable();
            //     $table->Integer('c_l_balance_from_account_id')->unsigned()->nullable();
            //     $table->foreign('c_l_balance_from_account_id')->references('id')->on('account_details');
            //     $table->timestamps();
            // });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Drop Table of account_details if exist
        Schema::dropIfExists('account_details');
    }
}
