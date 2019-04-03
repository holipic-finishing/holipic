<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSnapPhotoDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snap_photo_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('snap_photo_id')->unsigned();
            $table->string('image_resize');
            $table->string('image_final');
            $table->boolean('is_booking')->default(0);
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
       
        Schema::drop('snap_photo_details');
        
    }
}
