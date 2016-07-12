<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeownersInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create home_owner_information Table in DB if it doesn't exist
        if(!Schema::hasTable('home_owner_information')){
            Schema::create('home_owner_information', function (Blueprint $table) {
                $table->increments('id');
                // $table->Integer('created_by')->unsigned();
                // $table->foreign('created_by')->references('id')->on('users');
                // $table->Integer('updated_by')->unsigned();
                // $table->foreign('updated_by')->references('id')->on('users');
                $table->string('first_name',255);
                $table->string('last_name',255);
                $table->string('middle_name',255);
                $table->string('member_occupation',255);
                $table->string('residence_tel_no',13);
                $table->string('member_office_tel_no',13);
                $table->string('member_mobile_no',15);
                $table->string('member_email_address',255)->unique();
                $table->string('member_civil_status',255);
                $table->string('member_gender',255);
                $table->string('member_date_of_birth',255);
                //$table->boolean('member_active');
                $table->longText('member_address');
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
        //Drop Table of home_owner_information if exist
        Schema::dropIfExists('home_owner_information');
    }
}
