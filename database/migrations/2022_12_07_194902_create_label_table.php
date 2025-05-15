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
        Schema::create('label', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identifier', 100)->unique()->nullable();
            $table->integer('status')->nullable();
            $table->integer('type')->nullable();
            
            $table->engine = 'MyISAM';

            $table->index(['identifier']);
            $table->index(['status']);
            $table->index(['type']);
        });

        
        Schema::create('label_word', function (Blueprint $table) {
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
        Schema::dropIfExists('label');
        Schema::dropIfExists('label_word');
    }
};
