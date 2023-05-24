<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfileUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profile_updates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('instructor_id')->nullable();
            $table->foreign('instructor_id')->references('id')->on('users');
            $table->string('name')->nullable();
            $table->smallInteger('gender')->nullable()->comment('1=>male, 2=>female');
            $table->string('email')->unique();
            $table->string('country_code_phone')->nullable();
            $table->string('mobile')->nullable();
            $table->date('dob')->nullable();
            $table->string('password');
            $table->string('country_code')->nullable();
            $table->text('address')->nullable();
            $table->string('profile_picture')->nullable();
            $table->smallInteger('approve_status')->default(0)->comment('1=>approved, 2=>not approved');
            $table->rememberToken();
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
        Schema::dropIfExists('user_profile_updates');
    }
}
