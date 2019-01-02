<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBranchesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->nullable()->unsigned();
            $table->string('branch_name');
            $table->string('username');
            $table->integer('user_id')->nullable()->unsigned();
            $table->string('password');
            $table->string('branch_address')->nullable();
            $table->string('branch_phone_number', 50);
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::drop('branches');
    }
}
