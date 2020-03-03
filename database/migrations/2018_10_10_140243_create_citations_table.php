<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitationsTable extends Migration
{

    public function up()
    {
        Schema::create('citations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_owners')->nullable();
            $table->string('genders')->nullable();
            $table->string('business_name')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postcode')->nullable();
            $table->string('virtual')->nullable();
            $table->string('offices_same_city')->nullable();
            $table->string('phone')->nullable();
            $table->string('business_changes')->nullable();
            $table->string('email_address')->nullable();
            $table->longText('hours_of_operation')->nullable();
            $table->string('years_in_business')->nullable();
            $table->string('tagline')->nullable();
            $table->longText('business_description')->nullable();
            $table->string('payments_accepted')->nullable();
            $table->string('website_url')->nullable();
            $table->string('google_maps_url')->nullable();
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->string('google_plus')->nullable();
            $table->string('categories')->nullable();
            $table->string('services_offer')->nullable();
            $table->string('products_offer')->nullable();
            $table->longText('service_description_1')->nullable();
            $table->longText('service_description_2')->nullable();
            $table->longText('service_description_3')->nullable();
            $table->string('areas_served')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('profile_logo')->nullable();
            $table->integer('projects_id')->unsigned()->index()->nullable();
            $table->foreign('projects_id')->references('id')->on('projects')->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('citations');
    }
}
