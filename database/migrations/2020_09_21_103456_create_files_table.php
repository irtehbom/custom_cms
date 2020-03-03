<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('originalName')->nullable(true);
            $table->longText('mimeType')->nullable(true);
            $table->integer('size')->nullable(true);
            $table->string('path')->nullable(true);
            $table->string('filename')->nullable(true);
            $table->string('type')->nullable(true);
             $table->string('user_name')->nullable();
            $table->integer('messages_id')->unsigned()->index()->nullable();
            $table->foreign('messages_id')->references('id')->on('messages')->onDelete('cascade');
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
        Schema::dropIfExists('files');
    }
}
