<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLearningModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_modules', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->integer('author_id')->unsigned();
            $table->string('zoom_url')->nullable();
            $table->string('wistia_id')->nullable();
            $table->string('wistia_hashed_id')->nullable();
            $table->integer('wistia_duration')->nullable();
            $table->string('wistia_thumbnail')->nullable();
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
        Schema::drop('learning_modules');
    }
}
