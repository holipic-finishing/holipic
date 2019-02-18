<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrenciesToPhotoPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('photo_packages', function (Blueprint $table) {
            $table->integer('dollar');
            $table->integer('euro');
            $table->integer('indo');
            $table->integer('turkey');
            $table->integer('vn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('photo_packages', function (Blueprint $table) {
            Schema::dropIfExists('dollar');
            Schema::dropIfExists('euro');
            Schema::dropIfExists('indo');
            Schema::dropIfExists('turkey');
            Schema::dropIfExists('vn');
        });
    }
}
