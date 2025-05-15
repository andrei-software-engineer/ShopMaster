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
        Schema::create('orderjurnal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idorder')->nullable();
            $table->bigInteger('data')->nullable();
            $table->tinyInteger('orderjurnaltype')->nullable();
            $table->bigInteger('idrole')->nullable();
            $table->bigInteger('iduser')->nullable();
            $table->bigInteger('status')->nullable();
            $table->bigInteger('paystatus')->nullable();
            $table->bigInteger('idpaymethod')->nullable();
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
        Schema::dropIfExists('orderjurnal');
    }
};
