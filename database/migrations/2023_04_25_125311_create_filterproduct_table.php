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
        Schema::create('filterproduct', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idproduct')->nullable();
            $table->bigInteger('idfilter')->nullable();
            $table->bigInteger('idfiltervalue')->nullable();
            $table->float('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filterproduct');
    }
};
