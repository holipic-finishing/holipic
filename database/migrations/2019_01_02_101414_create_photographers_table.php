<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePhotographersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photographers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('branch_id')->unsigned();
            $table->string('name');
            $table->string('phone_number');
            $table->string('address');
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('branch_id')->references('id')->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('photographers');
    }
}
