<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitionPaperSubmittedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_paper_submitteds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('competition_id')->nullable();
            $table->foreign('competition_id')->references('id')->on('competition_controllers');
            $table->unsignedBigInteger('competition_paper_id')->nullable();
            $table->foreign('competition_paper_id')->references('id')->on('competition_papers');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('competition_categories');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('paper_type')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('total_marks')->nullable();
            $table->string('user_marks')->nullable();
            $table->string('result')->nullable();
            $table->string('prize')->nullable();
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
        Schema::dropIfExists('competition_paper_submitteds');
    }
}
