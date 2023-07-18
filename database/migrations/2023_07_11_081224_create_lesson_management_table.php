<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_management', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('survey_id')->nullable();
            $table->foreign('survey_id')->references('id')->on('surveys');
            $table->unsignedBigInteger('question_template_id')->nullable();
            $table->foreign('question_template_id')->references('id')->on('question_templates');
            $table->string('title')->nullable();
            //$table->smallInteger('type')->nullable()->comment('1 -> free, 2 -> paid');
            //$table->string('amount')->nullable();
            // $table->smallInteger('stopwatch_timing')->nullable()->comment('1 -> yes, 2 -> no');
            // $table->smallInteger('preset_timing')->nullable()->comment('1 -> yes, 2 -> no');
            $table->string('question_type')->nullable()->comment('1 -> vertical, 2 -> horizontal');
            $table->text('description')->nullable();
            $table->smallInteger('status')->nullable()->comment('1 -> active, 2 -> inactive');
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
        Schema::dropIfExists('lesson_management');
    }
}
