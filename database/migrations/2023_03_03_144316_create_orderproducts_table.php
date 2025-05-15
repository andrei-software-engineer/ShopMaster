<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderproducts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idorder')->nullable();
            $table->bigInteger('idproduct')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->bigInteger('quantity')->nullable();
            $table->string('description')->nullable();
            $table->bigInteger('status')->nullable();
            $table->bigInteger('paystatus')->nullable();
            $table->bigInteger('idpaymethod')->nullable();

            $table->float('pricewoutvat')->nullable();
            $table->float('real_pricewotvat')->nullable();
            $table->float('discount_percent')->nullable();
            $table->float('discount_value')->nullable();
            $table->float('real_vat')->nullable();
            $table->float('real_price')->nullable();
            $table->float('total_real_pricewotvat')->nullable();
            $table->float('total_discount_value')->nullable();
            $table->float('total_real_vat')->nullable();
            $table->float('total_real_price')->nullable();

            $table->float('total_achitat')->nullable();
            $table->float('total_datorie')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orderproducts');
    }
};
