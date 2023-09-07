<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempStudentCompetitionResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_student_competition_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cru_id')->nullable();
            $table->foreign('cru_id')->references('id')->on('competition_result_uploads');
            $table->unsignedBigInteger('competition_id')->nullable();
            $table->foreign('competition_id')->references('id')->on('competition_controllers');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('competition_categories');
            $table->string('total_marks')->nullable();
            $table->string('result')->nullable();
            $table->string('rank')->nullable();
            $table->string('abacus_grade')->nullable();
            $table->string('mental_grade')->nullable();
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
        Schema::dropIfExists('temp_student_competition_results');
    }
}
