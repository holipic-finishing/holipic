<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnEmailAndIndenficationCardOnPhotographerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('photographers', function (Blueprint $table) {
             $table->string('avatar')->nullable();
             $table->string('email')->nullable();
             $table->string('identification_card')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('photographers', function (Blueprint $table) {
            Schema::dropIfExists('avatar');
            Schema::dropIfExists('email');
            Schema::dropIfExists('identification_card');
        });
    }
}
