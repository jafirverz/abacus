<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitionQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('competition_paper_id')->nullable();
            $table->foreign('competition_paper_id')->references('id')->on('competition_papers');
            $table->string('question_1')->nullable();
            $table->string('question_2')->nullable();
            $table->string('symbol')->nullable();
            $table->string('answer')->nullable();
            $table->string('marks')->nullable();
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
        Schema::dropIfExists('competition_questions');
    }
}
