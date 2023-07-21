<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->string('level_id')->nullable();
            // $table->foreign('level_id')->references('id')->on('levels');
            $table->unsignedBigInteger('instructor_id')->nullable();
            $table->foreign('instructor_id')->references('id')->on('instructors');
            $table->unsignedBigInteger('user_type_id')->nullable();
            $table->foreign('user_type_id')->references('id')->on('user_types');
            $table->string('account_id')->nullable();
            $table->string('name')->nullable();
            $table->smallInteger('gender')->nullable()->comment('1=>male, 2=>female');
            $table->smallInteger('mental_grade_id')->nullable();
            $table->smallInteger('abacus_grade_id')->nullable();
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('country_code_phone')->nullable();
            $table->string('mobile')->nullable();
            $table->date('dob')->nullable();
            $table->string('verification_token')->unique();
            $table->string('password');
            $table->string('country_code')->nullable();
            $table->text('address')->nullable();
            $table->boolean('subscription')->default(0);
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
        Schema::dropIfExists('users');
    }
}
