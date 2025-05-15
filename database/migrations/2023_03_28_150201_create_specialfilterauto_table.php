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
        Schema::create('specialfilterauto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('parentmodel',100)->index()->nullable();
            $table->bigInteger('parentmodelid')->index()->default(-1);
            $table->bigInteger('idSpecialFilter')->index()->default(-1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specialfilterauto');
    }
};
