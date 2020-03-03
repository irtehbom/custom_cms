<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestPostingPipelineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_posting_pipeline', function (Blueprint $table) {
            $table->increments('id');
            $table->string('scheme')->nullable();
            $table->string('root_domain')->nullable();
            $table->string('url')->nullable();
            $table->string('category')->nullable();
            $table->string('stage')->nullable();
            $table->longText('notes')->nullable();
            $table->string('analysed')->nullable();
            $table->integer('flagged')->nullable();
            $table->string('added_by_user')->nullable();
            $table->string('updated_by_user')->nullable();
            $table->integer('projects_id')->unsigned()->index();
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
        Schema::dropIfExists('guest_posting_pipeline');
    }
}
