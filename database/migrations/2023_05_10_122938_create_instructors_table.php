<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructors', function (Blueprint $table) {
            $table->bigIncrements('id');
//            $table->unsignedBigInteger('role_id');
//            $table->foreign('role_id')->references('id')->on('roles');
//            $table->unsignedBigInteger('level_id');
//            $table->foreign('level_id')->references('id')->on('levels');
            $table->string('account_id')->nullable();
            $table->string('fullname')->nullable();
            $table->smallInteger('gender')->nullable()->comment('1=>male, 2=>female');
            $table->smallInteger('mental_grade_id')->nullable();
            $table->smallInteger('abacus_grade_id')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mobile')->nullable();
            $table->string('password');
            $table->string('country_code')->nullable();
            $table->text('address')->nullable();
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
        Schema::dropIfExists('instructors');
    }
}
