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
        Schema::create('faqresponses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idfaq')->nullable();
            $table->bigInteger('status')->nullable();
            $table->bigInteger('ordercriteria')->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq_responses');
    }
};
