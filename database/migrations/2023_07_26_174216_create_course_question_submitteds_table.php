<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseQuestionSubmittedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_question_submitteds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('course_submitted_id')->nullable();
            $table->foreign('course_submitted_id')->references('id')->on('course_submitteds');
            $table->unsignedBigInteger('question_id')->nullable();
            $table->foreign('question_id')->references('id')->on('test_paper_question_details');
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
        Schema::dropIfExists('course_question_submitteds');
    }
}
