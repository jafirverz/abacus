<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('menu_id');
            $table->tinyInteger('new_tab');
            $table->string('title');
            $table->string('external_link');
            $table->integer('page_id');
            $table->integer('view_order')->default(0);
            $table->integer('status')->comment('1 -> Active, 2 -> Inactive');
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
        Schema::dropIfExists('menu_lists');
    }
}
