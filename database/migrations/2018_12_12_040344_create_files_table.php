<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->string('name');
            $table->string('storage_url')->length(500);
            $table->bigInteger('file_size');
            $table->datetime('uploaded_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('company_id');
            $table->integer('user_id');
            $table->string('status')->length(1)->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('files');
    }
}
