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
        Schema::create('attachements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('status')->nullable();
            $table->string('parentmodel',100)->index()->nullable();
            $table->tinyInteger('isdefault')->nullable();
            $table->bigInteger('idsystemfile')->nullable();
            $table->bigInteger('oredrcriteria')->index()->nullable();
            $table->bigInteger('parentmodelid')->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachements');
    }
};
