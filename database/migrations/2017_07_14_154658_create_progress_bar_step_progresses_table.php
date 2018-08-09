<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgressBarStepProgressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress_bar_step_progresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('progress_bar_step_id');
            $table->integer('participant_id');
            $table->integer('completed')->default('0');
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
        Schema::drop('progress_bar_step_progresses');
    }
}
