<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_choices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('survey_question_option_id')->nullable();
            $table->foreign('survey_question_option_id')->references('id')->on('survey_question_options');
            $table->string('title');
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
        Schema::dropIfExists('option_choices');
    }
}
