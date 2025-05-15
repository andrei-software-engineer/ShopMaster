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
        Schema::create('algcategory', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('idallegro', 200)->nullable();
            $table->string('name', 200)->nullable();
            $table->string('parent', 200)->nullable();
            $table->bigInteger('leaf')->nullable();
            $table->json('options')->nullable();
            $table->bigInteger('levelprocess')->nullable();
            $table->bigInteger('infoprocess')->nullable();

            $table->engine = 'MyISAM';

            $table->index(['id']);
            $table->index(['parent']);
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
        Schema::dropIfExists('algcategory');
    }
};
