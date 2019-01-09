<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyPackagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('package_name');
            $table->string('price');
            $table->string('offer');
            $table->integer('total_photo');
            $table->string('album');
            $table->integer('photo_on_disc');
            $table->integer('poster');
            $table->integer('company_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('company_packages');
    }
}
