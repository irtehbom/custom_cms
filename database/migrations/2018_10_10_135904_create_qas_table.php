<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('main_contact')->nullable();
            $table->string('other_contact')->nullable();
            $table->longText('sales')->nullable();
            $table->longText('potential_keywords')->nullable();
            $table->longText('popular_products_services')->nullable();
            $table->longText('profitable_products_services')->nullable();
            $table->longText('competitors')->nullable();
            $table->string('geography')->nullable();
            $table->longText('goals')->nullable();
            $table->string('other_urls')->nullable();
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
        Schema::dropIfExists('qas');
    }
}
