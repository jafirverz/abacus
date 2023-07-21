<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestPaperQuestionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_paper_question_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('test_paper_question_id');
            $table->foreign('test_paper_question_id')->references('id')->on('test_paper_details');
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
        Schema::dropIfExists('test_paper_question_details');
    }
}
