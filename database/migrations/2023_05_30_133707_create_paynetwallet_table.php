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
        Schema::create('paynetwallet', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ordercriteria')->nullable();
            $table->bigInteger('status')->nullable();
            $table->bigInteger('isdefault')->nullable();
            $table->string('merchant_code')->nullable();
            $table->string('merchant_secretkey')->nullable();
            $table->string('merchant_user')->nullable();
            $table->string('merchant_userpass')->nullable();
            $table->string('notification_secretkey')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paynetwallet');
    }
};
