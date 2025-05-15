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
        Schema::create('slug', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->index()->nullable();
            $table->bigInteger('idlang')->index()->nullable();
            $table->string('parentmodel',100)->index()->nullable();
            $table->bigInteger('parentmodelid')->index()->nullable();

            $table->unique(['slug', 'idlang']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slug');
    }
};
