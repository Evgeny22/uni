<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsDraftToDiscussionQuestionAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_discussion_question_answers', function (Blueprint $table) {
            $table->integer('is_draft')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_discussion_question_answers', function (Blueprint $table) {
            $table->dropColumn('is_draft');
        });
    }
}
