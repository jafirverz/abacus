<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandaloneQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standalone_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('standalone_page_id')->nullable();
            $table->foreign('standalone_page_id')->references('id')->on('standalone_pages');
            $table->unsignedBigInteger('question_template_id')->nullable();
            $table->foreign('question_template_id')->references('id')->on('question_templates');
            $table->string('question_1')->nullable();
            $table->string('question_2')->nullable();
            $table->string('symbol')->nullable();
            $table->string('answer')->nullable();
            $table->string('marks')->nullable();
            $table->string('blocks')->nullable();
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
        Schema::dropIfExists('standalone_questions');
    }
}
