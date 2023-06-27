<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradingListingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grading_listing_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('grading_listing_id');
            $table->foreign('grading_listing_id')->references('id')->on('grading_exam_lists');
            $table->string('title')->nullable();
            $table->string('uploaded_file')->nullable();
            $table->float('price', 10, 2)->nullable();
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
        Schema::dropIfExists('grading_listing_details');
    }
}
