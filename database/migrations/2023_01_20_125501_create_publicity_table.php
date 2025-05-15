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
        Schema::create('publicity', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('advsection')->nullable();
            $table->bigInteger('advtype')->nullable();
            $table->string('parentmodel',100)->index()->nullable();
            $table->bigInteger('parentmodelid')->index()->nullable();
            $table->bigInteger('status')->nullable();
            $table->bigInteger('idimage')->nullable();
            $table->bigInteger('idimagemobile')->nullable();
            $table->bigInteger('idvideo')->nullable();
            $table->timestamp('startdate')->nullable();
            $table->timestamp('enddate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publicity');
    }
};
