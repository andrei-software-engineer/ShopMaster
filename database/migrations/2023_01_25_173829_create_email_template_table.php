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
        Schema::create('emailtemplate', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('status')->nullable();
            $table->bigInteger('idfromemail')->nullable();
            $table->string('identifier')->nullable();
            $table->string('toemail')->nullable();
            $table->string('replyto')->nullable();
            $table->string('cc')->nullable();
            $table->string('bcc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_template');
    }
};
