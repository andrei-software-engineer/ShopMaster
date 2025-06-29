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
        Schema::create('modelauto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ordercriteria')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('idmarca')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modelauto');
    }
};
