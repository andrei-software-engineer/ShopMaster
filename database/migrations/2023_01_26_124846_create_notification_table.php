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
        Schema::create('notification', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('parentmodel')->index()->nullable();
            $table->bigInteger('parentmodelid')->index()->nullable();
            $table->bigInteger('type')->nullable();
            $table->bigInteger('destination')->nullable();
            $table->bigInteger('date')->nullable();
            $table->bigInteger('priority')->nullable();
            $table->bigInteger('idtemplate')->nullable();
            $table->bigInteger('status')->nullable();
            $table->bigInteger('datetosend')->nullable();
            $table->bigInteger('mintimetosend')->nullable();
            $table->bigInteger('maxtimetosend')->nullable();
            $table->bigInteger('idlang')->nullable();
            $table->string('idfiles', 100)->nullable();
            $table->string('deletefiles', 100)->nullable();
            $table->mediumText('prepareddata')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification');
    }
};
