<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradingPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grading_papers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('question_template_id')->nullable();
            $table->foreign('question_template_id')->references('id')->on('question_templates');
            $table->unsignedBigInteger('grading_exam_id')->nullable();
            $table->foreign('grading_exam_id')->references('id')->on('grading_exams');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('grading_categories');
            $table->string('paper_type')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('time')->nullable();
            $table->string('pdf_file')->nullable();
            $table->string('price')->nullable();
            $table->string('competition_type')->nullable()->comment('physical, online');
            $table->string('type')->nullable()->comment('horizontal, vertical');
            $table->string('timer')->nullable()->comment('yes, no');
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
        Schema::dropIfExists('grading_papers');
    }
}
