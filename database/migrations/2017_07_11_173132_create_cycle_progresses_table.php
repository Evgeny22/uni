<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCycleProgressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cycle_progresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cycle_id');
            $table->integer('cycle_step_id');
            $table->integer('author_id');
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
        Schema::drop('cycle_progresses');
    }
}
