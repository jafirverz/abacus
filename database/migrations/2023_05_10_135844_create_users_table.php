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
            $table->unsignedInteger('role_id');
            $table->string('level_id')->nullable();
            $table->unsignedInteger('instructor_id')->nullable();
            $table->unsignedInteger('user_type_id')->nullable();
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
            $table->text('year_attained_qualified_instructor')->nullable();
            $table->text('year_attained_senior_instructor')->nullable();
            $table->text('highest_abacus_grade')->nullable();
            $table->text('highest_mental_grade')->nullable();
            $table->text('awards')->nullable();
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
