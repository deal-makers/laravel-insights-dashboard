<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Detections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('client_id');
            $table->string('tags')->nullable();
            $table->string('title');
            $table->integer('emergency')->default(0);
            $table->integer('detection_level')->default(0);
            $table->integer('tlp')->default(0);
            $table->integer('pap')->default(0);
            $table->text('comment')->nullable();
            $table->text('description')->nullable();
            $table->text('scenario')->nullable();
            $table->text('tech_detail')->nullable();
            $table->text('reference')->nullable();
            $table->string('evidence')->nullable();
            $table->text('ioc')->nullable();
            
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
        Schema::dropIfExists('detections');
    }
}
