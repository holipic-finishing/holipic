<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePackagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('package_name')->length(255);
            $table->string('short_description')->length(255)->nullable();
            $table->string('full_description')->nullable();
            $table->string('secure_storage')->nullable();
            $table->integer('file_upload')->nullable();
            $table->integer('minimum_user')->nullable();
            $table->string('max_user')->nullable();
            $table->decimal('fee',8,1)->nullable();
            $table->integer('company_id')->nullable();
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
        Schema::drop('packages');
    }
}
