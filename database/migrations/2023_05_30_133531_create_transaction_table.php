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
        Schema::create('transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('date')->nullable();
            $table->bigInteger('status')->nullable();
            $table->bigInteger('iduser')->nullable();
            $table->bigInteger('idparentclass')->nullable();
            $table->string('parentclass')->nullable();

            $table->decimal('value')->nullable();
            $table->decimal('value_bilant')->nullable();
            
            $table->string('documentclass')->nullable();
            $table->bigInteger('iddocument')->nullable();

            $table->string('notes')->nullable();
            $table->bigInteger('type')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
};
