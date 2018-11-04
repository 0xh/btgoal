<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id')->unsinged();
            $table->integer('appointment_id')->unsigned();
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
            $table->integer('category_id')->nullable();
            $table->integer('contact_id')->nullable();
            $table->integer('organisation_id')->nullable();
            $table->string('title');
            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();
            $table->string('address')->nullable();
            $table->string('attendees')->nullable();
            $table->boolean('send_sms')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
