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
            $table->unsignedBigInteger('grading_paper_id')->nullable();
            $table->foreign('grading_paper_id')->references('id')->on('grading_papers');
            $table->string('question_1')->nullable();
            $table->string('question_2')->nullable();
            $table->string('symbol')->nullable();
            $table->string('answer')->nullable();
            $table->string('marks')->nullable();
            $table->string('block')->nullable();
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
