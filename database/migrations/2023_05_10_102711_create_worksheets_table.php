<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worksheets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('role_id');
//            $table->unsignedBigInteger('level_id');
//            $table->unsignedBigInteger('topic_id');
            $table->unsignedBigInteger('question_template_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles');
//            $table->foreign('level_id')->references('id')->on('levels');
//            $table->foreign('topic_id')->references('id')->on('topics');
            $table->foreign('question_template_id')->references('id')->on('question_templates');
            $table->string('title')->nullable();
//            $table->string('fee')->nullable();
            $table->smallInteger('type')->nullable()->comment('1 -> free, 2 -> paid');
            $table->string('amount')->nullable();

            $table->smallInteger('stopwatch_timing')->nullable()->comment('1 -> yes, 2 -> no');
            $table->smallInteger('preset_timing')->nullable()->comment('1 -> yes, 2 -> no');
            $table->string('question_type')->nullable()->comment('1 -> vertical, 2 -> horizontal');
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
        Schema::dropIfExists('worksheets');
    }
}
