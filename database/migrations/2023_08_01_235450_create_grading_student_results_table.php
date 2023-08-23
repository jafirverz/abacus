<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradingStudentResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grading_student_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('grading_id')->nullable();
            $table->foreign('grading_id')->references('id')->on('grading_exams');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('total_marks')->nullable();
            $table->string('result')->nullable();
            $table->string('rank')->nullable();
            $table->string('abacus_grade')->nullable();
            $table->string('mental_grade')->nullable();
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
        Schema::dropIfExists('grading_student_results');
    }
}
