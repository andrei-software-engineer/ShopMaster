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
        Schema::create('system_file', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->bigInteger('size')->nullable();
            $table->string('filetype')->nullable();
            $table->string('location')->nullable();
            $table->string('md5')->index()->nullable();
            $table->bigInteger('isused')->nullable();
            $table->string('permission')->nullable();

            $table->unique(['md5', 'permission']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_file');
    }
};
