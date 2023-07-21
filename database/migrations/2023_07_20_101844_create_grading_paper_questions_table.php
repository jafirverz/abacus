<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradingPaperQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grading_paper_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('grading_paper_question_id');
            $table->foreign('grading_paper_question_id')->references('id')->on('grading_papers');
            $table->text('input_1')->nullable();
            $table->string('input_2')->nullable();
            $table->string('input_3')->nullable();
            $table->integer('answer')->nullable();
            $table->integer('marks')->nullable();
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
        Schema::dropIfExists('grading_paper_questions');
    }
}
