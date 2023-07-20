<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitionPaperQuestionSubmittedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_paper_question_submitteds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('competition_paper_submitted_id')->nullable();
            $table->foreign('competition_paper_submitted_id', 'cps_id')->references('id')->on('competition_paper_submitteds');
            $table->unsignedBigInteger('competition_question_id')->nullable();
            $table->foreign('competition_question_id', 'cq_id')->references('id')->on('competition_questions');
            $table->string('question_answer')->nullable();
            $table->string('user_answer')->nullable();
            $table->string('marks')->nullable();
            $table->string('user_marks')->nullable();
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
        Schema::dropIfExists('competition_paper_question_submitteds');
    }
}
