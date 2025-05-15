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
        Schema::create('paynettransaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('parentclass')->nullable();
            $table->bigInteger('idparentclass')->nullable();
            $table->bigInteger('idpaynetwallet')->nullable();
            $table->bigInteger('status')->nullable();
            $table->decimal('tr_amount')->nullable();
            $table->decimal('site_amount')->nullable();
            $table->bigInteger('date')->nullable();

            $table->string('EventType')->nullable();
            $table->string('PaymentSaleAreaCode')->nullable();
            $table->string('PaymentCustomer')->nullable();
            $table->string('PaymentStatusDate')->nullable();
            $table->bigInteger('PaymentAmount')->nullable();
            $table->string('PaymentMerchant')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paynettransaction');
    }
};
