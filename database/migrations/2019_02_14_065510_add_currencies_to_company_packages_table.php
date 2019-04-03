<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrenciesToCompanyPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_packages', function (Blueprint $table) {
            $table->decimal('dollar', 30, 10)->default(0,0);
            $table->decimal('euro', 30, 10)->default(0,0);
            $table->decimal('indo', 30, 10)->default(0,0);
            $table->decimal('turkey', 30, 10)->default(0,0);
            $table->decimal('vn', 30, 10)->default(0,0);
            $table->decimal('price', 30,10)->nullable()->default(0,0)->change();
            $table->decimal('offer', 30,10)->nullable()->default(0,0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_packages', function (Blueprint $table) {
            $table->dropColumn(['dollar', 'euro', 'indo', 'turkey', 'vn']);
        });
    }
}
