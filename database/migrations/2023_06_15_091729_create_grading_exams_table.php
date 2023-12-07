<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradingExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grading_exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->date('date_of_competition')->nullable();
            $table->string('start_time_of_competition')->nullable();
            $table->string('end_time_of_competition')->nullable();
            $table->text('description')->nullable();
            $table->string('competition_type')->nullable()->comment('online, physical');
            $table->smallInteger('status')->nullable()->comment('1=>published, 2=>draft');
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
        Schema::dropIfExists('grading_exams');
    }
}
