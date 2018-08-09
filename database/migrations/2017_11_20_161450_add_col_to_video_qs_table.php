<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColToVideoQsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_discussion_questions', function (Blueprint $table) {
            $table->integer('discussion_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_discussion_questions', function (Blueprint $table) {
            $table->dropColumn('discussion_id');
        });
    }
}
