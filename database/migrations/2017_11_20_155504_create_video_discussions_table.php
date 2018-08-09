<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_discussions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id');
            $table->integer('video_id');
            $table->integer('column_id');
            $table->integer('annotation_id');
            $table->string('title', 255);
            $table->text('annotation');
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
        Schema::drop('video_discussions');
    }
}
