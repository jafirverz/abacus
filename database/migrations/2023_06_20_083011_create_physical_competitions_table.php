<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhysicalCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physical_competitions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('competition_paper_id')->nullable();
            $table->foreign('competition_paper_id')->references('id')->on('competition_papers');
            $table->string('file_name');
            $table->string('price');
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
        Schema::dropIfExists('physical_competitions');
    }
}
