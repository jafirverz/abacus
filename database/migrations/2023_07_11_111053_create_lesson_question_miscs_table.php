<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonQuestionMiscsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_question_miscs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lesson_question_management_id')->nullable();
            $table->foreign('lesson_question_management_id')->references('id')->on('lesson_question_management');
            $table->string('question_1')->nullable();
            $table->string('question_2')->nullable();
            $table->string('symbol')->nullable();
            $table->string('answer')->nullable();
            $table->string('marks')->nullable();
            $table->smallInteger('block')->nullable();
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
        Schema::dropIfExists('lesson_question_miscs');
    }
}
