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
        Schema::create('system_video', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('host',100)->nullable();
            $table->string('videoid',50)->nullable();
            $table->string('name',1000)->nullable();
            $table->string('video_img',1000)->nullable();
            $table->string('location',1000)->nullable();
            $table->mediumText('script')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_video');
    }
};
