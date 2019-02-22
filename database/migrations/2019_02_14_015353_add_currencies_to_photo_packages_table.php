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
            $table->decimal('dollar', 30, 10)->default(0,0);
            $table->decimal('euro', 30, 10)->default(0,0);
            $table->decimal('indo', 30, 10)->default(0,0);
            $table->decimal('turkey', 30, 10)->default(0,0);
            $table->decimal('vn', 30, 10)->default(0,0);
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
