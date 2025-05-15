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
        Schema::create('location', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idparent')->nullable();
            $table->string('code')->nullable();
            $table->tinyInteger('level')->nullable();
            $table->bigInteger('status')->nullable();
            $table->bigInteger('order')->nullable();
            $table->string('shortname')->nullable();
            $table->bigInteger('idlogo')->nullable();
            $table->float('price')->nullable();
            $table->tinyInteger('isdefault')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location');
    }
};
