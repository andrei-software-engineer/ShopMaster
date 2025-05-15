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
        Schema::create('algparametervalue', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('idallegroparent', 200)->nullable();
            $table->string('idallegro', 200)->nullable();

            $table->string('value', 200)->nullable();
            
            $table->json('depends')->nullable();

            $table->bigInteger('levelprocess')->nullable();
            $table->bigInteger('infoprocess')->nullable();

            $table->engine = 'MyISAM';

            $table->index(['id']);
            $table->index(['levelprocess']);
            $table->index(['infoprocess']);
            $table->index(['idallegro']);
            $table->index(['idallegroparent']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('algparametervalue');
    }
};
