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
        Schema::create('algcategoryparameter', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('idallegrocategory', 200)->nullable();
            $table->string('idallegroparameter', 200)->nullable();
            
            $table->bigInteger('levelprocess')->nullable();
            $table->bigInteger('infoprocess')->nullable();

            $table->engine = 'MyISAM';

            $table->index(['id']);
            $table->index(['levelprocess']);
            $table->index(['infoprocess']);
            $table->index(['idallegrocategory']);
            $table->index(['idallegroparameter']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('algcategoryparameter');
    }
};
