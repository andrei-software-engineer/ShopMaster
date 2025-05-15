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
        Schema::create('offer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idproduct')->nullable();
            $table->bigInteger('priority')->nullable();
            $table->bigInteger('minq')->nullable();
            $table->bigInteger('maxq')->nullable();
            $table->float('pricewoutvat')->nullable();
            $table->float('real_pricewotvat')->nullable();
            $table->float('discount_percent')->nullable();
            $table->float('discount_value')->nullable();
            $table->bigInteger('status')->nullable();
            $table->float('vatcote')->nullable();
            $table->float('real_vat')->nullable();
            $table->float('real_price')->nullable();
            $table->bigInteger('start_date')->nullable();
            $table->bigInteger('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer');
    }
};
