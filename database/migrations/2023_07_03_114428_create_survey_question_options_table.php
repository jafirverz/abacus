<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyQuestionOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_question_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('survey_question_id')->nullable();
            $table->foreign('survey_question_id')->references('id')->on('survey_questions');
            $table->string('title')->nullable();
            $table->string('option_type')->nullable()->comment('with_title, without_title');
            $table->smallInteger('status')->nullable()->comment('1=>active, 2=>inactive');
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
        Schema::dropIfExists('survey_question_options');
    }
}
