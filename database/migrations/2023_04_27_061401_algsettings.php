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
        Schema::create('algsettings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('config', 200)->nullable();
            $table->string('value', 2000)->nullable();

            $table->engine = 'MyISAM';

            $table->index(['id']);
            $table->index(['config']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('algsettings');
    }
};
