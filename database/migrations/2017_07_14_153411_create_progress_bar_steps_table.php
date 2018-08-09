<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgressBarStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress_bar_steps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('progress_bar_id');
            $table->integer('author_id');
            $table->string('name', '255');
            $table->string('link', '255');
            $table->integer('type');
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
        Schema::drop('progress_bar_steps');
    }
}
