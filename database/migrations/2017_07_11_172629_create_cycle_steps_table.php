<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCycleStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cycle_steps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cycle_id');
            $table->integer('object_id');
            $table->string('object_type', '255');
            $table->string('type', '255');
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
        Schema::drop('cycle_steps');
    }
}
