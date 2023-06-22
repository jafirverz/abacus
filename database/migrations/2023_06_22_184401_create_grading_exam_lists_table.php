<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradingExamListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grading_exam_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('grading_exams_id');
            $table->foreign('grading_exams_id')->references('id')->on('grading_exams');
            $table->string('heading')->nullable();
            $table->text('json_content')->nullable();
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
        Schema::dropIfExists('grading_exam_lists');
    }
}
