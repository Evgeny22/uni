<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_columns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('video_id');
            $table->integer('author_id');
            $table->string('name', '255');
            $table->string('color', '255');
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
        Schema::drop('video_columns');
    }
}
