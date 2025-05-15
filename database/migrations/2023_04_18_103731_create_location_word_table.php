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
        Schema::create('location_word', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('idparent')->nullable();
            $table->biginteger('idlang')->nullable();
            $table->string('attr', 100)->nullable();
            $table->string('value', 1000)->nullable();
            
            $table->engine = 'MyISAM';

            $table->index(['idparent']);
            $table->index(['idparent', 'idlang']);
            $table->index(['idlang']);
            $table->index(['attr']);
            $table->unique(['idparent', 'idlang','attr']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_word');
    }
};
