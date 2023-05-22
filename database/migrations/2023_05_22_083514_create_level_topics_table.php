<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level_topics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('worksheet_id');
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('topic_id');
            $table->foreign('worksheet_id')->references('id')->on('worksheets');
            $table->foreign('level_id')->references('id')->on('levels');
            $table->foreign('topic_id')->references('id')->on('topics');
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
        Schema::dropIfExists('level_topics');
    }
}
