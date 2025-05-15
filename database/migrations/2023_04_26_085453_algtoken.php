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
        Schema::create('algtoken', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('clientid', 200)->nullable();
            $table->string('clientsecret', 200)->nullable();

            $table->string('access_token', 2000)->nullable();
            $table->string('token_type', 200)->nullable();
            $table->string('refresh_token', 2000)->nullable();
            
            $table->bigInteger('expires_in')->nullable();
            $table->bigInteger('avaible_date')->nullable();
            
            $table->string('scope', 2000)->nullable();
            $table->bigInteger('allegro_api')->nullable();
            $table->string('jti', 200)->nullable();

            $table->engine = 'MyISAM';

            $table->index(['id']);
            $table->index(['clientid']);
            $table->index(['expires_in']);
            $table->index(['avaible_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('algtoken');
    }
};
