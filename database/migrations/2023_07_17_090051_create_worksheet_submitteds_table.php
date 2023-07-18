<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksheetSubmittedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worksheet_submitteds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('worksheet_id')->nullable();
            $table->foreign('worksheet_id')->references('id')->on('worksheets');
            $table->unsignedBigInteger('level_id')->nullable();
            $table->foreign('level_id')->references('id')->on('levels');
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
        Schema::dropIfExists('worksheet_submitteds');
    }
}
