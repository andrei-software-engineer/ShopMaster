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
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('iduser')->nullable();
            $table->string('uuid')->nullable();
            $table->bigInteger('status')->nullable();
            $table->bigInteger('paystatus')->nullable();
            $table->bigInteger('idpaymenthod')->nullable();
            $table->bigInteger('data')->nullable();
            $table->bigInteger('idmetodalivrare')->nullable();
            $table->bigInteger('dataplata')->nullable();
            $table->bigInteger('idorderpartener')->nullable();

            $table->float('total_real_pricewotvat')->nullable();
            $table->float('total_discount_value')->nullable();
            $table->float('total_real_vat')->nullable();
            $table->float('total_real_price')->nullable();
            $table->float('total_achitat')->nullable();
            $table->float('total_datorie')->nullable();

            $table->string('comments')->nullable();
            $table->string('destinatar_name')->nullable();
            $table->string('destinatar_company')->nullable();
            $table->string('destinatar_phone')->nullable();
            $table->string('destinatar_email')->nullable();
            $table->string('destinatar_address')->nullable();
            $table->string('destinatar_delivery_number')->nullable();
            $table->string('destinatar_idlocation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
};
