<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

class CreateNewDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date')->default(Carbon::now());
            $table->integer('prayer_requests')->default(0);
            $table->integer('testimonies')->default(0);
            $table->integer('mail_received')->default(0);
            $table->integer('users')->default(0);
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
        Schema::dropIfExists('new_data');
    }
}
