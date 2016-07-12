<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountSubGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('account_titles')){
            Schema::create('account_titles', function (Blueprint $table) {
                $table->increments('id');
                $table->Integer('account_group_id')->unsigned();
                $table->foreign('account_group_id')->references('id')->on('account_groups');
                $table->string('account_sub_group_name',255)->unique();
                $table->decimal('opening_balance',10,2)->default(0.00);
                $table->string('description',255)->default('No Description');
                $table->decimal('default_value',10,2)->default(0.00);
                $table->Integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users');
                $table->Integer('updated_by')->unsigned()->nullable();
                $table->foreign('updated_by')->references('id')->on('users');
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
        //Drop Table of account_titles if exist
        Schema::dropIfExists('account_titles');
    }
}
