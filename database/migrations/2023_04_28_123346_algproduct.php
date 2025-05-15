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
        Schema::create('algproduct', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('idallegro', 200)->nullable();

            $table->string('name', 200)->nullable();
            $table->text('category')->nullable();
            $table->text('parameters')->nullable();
            $table->text('images')->nullable();
            $table->text('description')->nullable();
            $table->text('isdraft')->nullable();
            
            $table->bigInteger('levelprocess')->nullable();
            $table->bigInteger('infoprocess')->nullable();

            $table->engine = 'MyISAM';

            $table->index(['id']);
            $table->index(['levelprocess']);
            $table->index(['infoprocess']);
            $table->index(['idallegro']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('algproduct');
    }
};
