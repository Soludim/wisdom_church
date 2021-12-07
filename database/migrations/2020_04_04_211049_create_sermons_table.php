<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSermonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sermons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('topic');
            $table->longText('content');
            $table->string('video_url')->nullable();
            $table->string('coverImage')->nullable();
            $table->string('speaker_name');   //preacher name
            $table->string('speaker_position');   //preacher position
            $table->string('speaker_image');   //preacher image
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sermons');
    }
}
