<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitionPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_papers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('question_template_id')->nullable();
            $table->unsignedBigInteger('competition_controller_id')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('time')->nullable();
            $table->string('type')->nullable()->comment('horizontal, vertical');
            $table->string('timer')->nullable()->comment('yes, no');;
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
        Schema::dropIfExists('competition_papers');
    }
}
