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
        Schema::create('paynettransactionjurnal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idpaynettransaction')->nullable();
            $table->bigInteger('date')->nullable();
            $table->bigInteger('transactionjurnaltype')->nullable();
            $table->bigInteger('idrole')->nullable();
            $table->bigInteger('iduser')->nullable();
            $table->bigInteger('status')->nullable();
            $table->string('note')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paynettransactionjurnal');
    }
};
