<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToVideoColumnObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_column_objects', function (Blueprint $table) {
            $table->integer('video_column_id');
            $table->string('object_id', '255');
            $table->string('object_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_column_objects', function (Blueprint $table) {
            $table->dropColumn('video_column_id');
            $table->dropColumn('object_id');
            $table->dropColumn('object_type');
        });
    }
}
