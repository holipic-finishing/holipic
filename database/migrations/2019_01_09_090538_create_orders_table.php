<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('branch_id');            
            $table->integer('photographer_id');            
            $table->integer('customer_id');        
            $table->decimal('total_amount',20,15);            
            $table->datetime('purchase_date');        
            $table->datetime('download_date');           
            $table->string('payment_method');          
            $table->string('purchase_from');           
            $table->string('status');     
            $table->string('invoice');            
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
        Schema::dropIfExists('orders');
    }
}
