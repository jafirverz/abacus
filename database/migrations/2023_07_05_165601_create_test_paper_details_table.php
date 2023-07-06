<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestPaperDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_paper_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('paper_id');
            $table->foreign('paper_id')->references('id')->on('test_papers');
            $table->string('question')->nullable();
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
        Schema::dropIfExists('test_paper_details');
    }
}
