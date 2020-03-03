<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time', function (Blueprint $table) {
            $table->increments('id');
            $table->float('time_logged')->nullable();
            $table->float('hours')->nullable();
            $table->float('minutes')->nullable();
            $table->string('user_name')->nullable();
            $table->dateTime('date')->nullable();
            $table->longText('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('type')->nullable();
            $table->integer('projects_id')->unsigned()->index()->nullable();
            $table->foreign('projects_id')->references('id')->on('projects')->onDelete('cascade');
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
        Schema::dropIfExists('time');
    }
}
