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
        Schema::create('filtervalue', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idfilter')->nullable();
            $table->bigInteger('orderctireatia')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('partener')->nullable();
            $table->string('partenerid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filtervalue');
    }
};
