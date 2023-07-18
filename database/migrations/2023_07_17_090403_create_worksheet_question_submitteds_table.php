<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksheetQuestionSubmittedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worksheet_question_submitteds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('worksheet_submitted_id')->nullable();
            $table->foreign('worksheet_submitted_id')->references('id')->on('worksheet_submitteds');
            $table->unsignedBigInteger('misc_question_id')->nullable();
            $table->foreign('misc_question_id')->references('id')->on('misc_questions');
            $table->string('question_answer');
            $table->string('user_answer');
            $table->string('marks');
            $table->string('user_marks');
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
        Schema::dropIfExists('worksheet_question_submitteds');
    }
}
