<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_submissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('test_id')->nullable();
            $table->foreign('test_id')->references('id')->on('test_management');
            $table->unsignedBigInteger('test_paper_question_id')->nullable();
            $table->foreign('test_paper_question_id')->references('id')->on('test_paper_details');
            $table->unsignedBigInteger('question_template_id')->nullable();
            $table->foreign('question_template_id')->references('id')->on('question_templates');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('total_marks')->nullable();
            $table->string('user_marks')->nullable();
            $table->string('result')->nullable();
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
        Schema::dropIfExists('test_submissions');
    }
}
