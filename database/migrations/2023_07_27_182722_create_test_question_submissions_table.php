<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestQuestionSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_question_submissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('test_submitted_id')->nullable();
            $table->foreign('test_submitted_id')->references('id')->on('test_submissions');
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
        Schema::dropIfExists('test_question_submissions');
    }
}
