<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsUser extends Migration {


    public function up() {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->longText('description')->nullable();
            $table->string('website')->nullable();
            $table->integer('ws_read')->nullable();
            $table->integer('client_read')->nullable();
            $table->string('start')->nullable();
            $table->string('end')->nullable();
            $table->integer('hours')->nullable();
            $table->string('cms_url')->nullable();
            $table->string('cms_username')->nullable();
            $table->string('cms_password')->nullable();
            $table->string('ftp_ip')->nullable();
            $table->string('ftp_username')->nullable();
            $table->string('ftp_password')->nullable();
            $table->string('analytics_viewid')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('projects');
    }

}
