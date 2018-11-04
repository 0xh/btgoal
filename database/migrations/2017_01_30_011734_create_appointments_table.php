<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id')->unsigned();
            $table->integer('psa_id')->nullable()->unsigned();
            $table->string('photo');
            $table->integer('category_id')->nullable()->unsigned();
            $table->integer('contact_id')->nullable()->unsigned();
            $table->integer('organisation_id')->nullable()->unsigned();
            $table->string('title');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('address')->nullable();
            $table->string('attendees')->nullable();
            $table->boolean('checkin')->nullable();
            $table->boolean('all_day')->nullable();
            $table->boolean('send_sms')->nullable();
            $table->timestamp('checkin_datetime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
