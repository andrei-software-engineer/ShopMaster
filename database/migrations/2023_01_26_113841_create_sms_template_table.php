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
        Schema::create('smstemplate', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('status')->nullable();
            $table->string('identifier')->nullable();
            $table->string('fromname')->nullable();
            $table->string('tonumber')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('smstemplate');
    }
};
