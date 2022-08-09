<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products__sales', function (Blueprint $table) {
            $table->id();
            $table->integer('qty_sales');
            $table->unsignedInteger('sale_id');
            $table->unsignedInteger('product_id');
            $table->doube('total_price');
            $table->timestamps();

            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('CASCADE');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products__sales');
    }
}
