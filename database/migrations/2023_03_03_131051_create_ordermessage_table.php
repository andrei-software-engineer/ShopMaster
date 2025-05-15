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
        Schema::create('ordermessage', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idorder')->nullable();
            $table->tinyInteger('visibilitytype')->nullable();
            $table->tinyInteger('ordermessagetype')->nullable();
            $table->bigInteger('data')->nullable();
            $table->string('message')->nullable();
            $table->bigInteger('idfile')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordermessage');
    }
};
