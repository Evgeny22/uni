<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoDiscussionQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_discussion_question_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id');
            $table->integer('video_discussion_id');
            $table->integer('video_discussion_question_id');
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
        Schema::drop('video_discussion_question_answers');
    }
}
