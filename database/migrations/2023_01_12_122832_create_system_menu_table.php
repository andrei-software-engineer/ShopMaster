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
        Schema::create('systemmenu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idparent')->nullable();
            $table->bigInteger('idpage')->nullable();
            $table->bigInteger('status')->nullable();
            $table->bigInteger('section')->nullable();
            $table->bigInteger('ordercriteria')->nullable();
            $table->bigInteger('linktype')->nullable();
            $table->string('customlink',1000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('systemmenu');
    }
};
