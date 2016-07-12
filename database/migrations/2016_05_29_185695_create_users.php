<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create users Table in DB if it doesn't exist
        if(!Schema::hasTable('users')){
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->Integer('home_owner_id')->unsigned()->nullable();
                $table->foreign('home_owner_id')->references('id')->on('home_owner_information');
                $table->Integer('user_type_id')->unsigned()->nullable();
                $table->foreign('user_type_id')->references('id')->on('user_type');
                $table->Integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users');
                $table->Integer('updated_by')->unsigned()->nullable();
                $table->foreign('updated_by')->references('id')->on('users');
                $table->string('first_name',255);
                $table->string('middle_name',255);
                $table->string('last_name',255);
                $table->string('email')->unique();
                $table->string('password', 60);
                $table->string('mobile_number',255);
                //$table->boolean('is_active')->default();
                $table->string('confirmation_code')->nullable();
                $table->rememberToken();
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
        //Drop Table of home_owner_cars if exist
        Schema::dropIfExists('users');
    }
}
