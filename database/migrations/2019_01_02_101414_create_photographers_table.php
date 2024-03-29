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
            $table->string('name');
            $table->string('phone_number');
            $table->string('address');
            $table->boolean('status')->default(1);
            $table->integer('branch_id');
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
        Schema::drop('photographers');
    }
}
