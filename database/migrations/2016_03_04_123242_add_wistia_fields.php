<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWistiaFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function(Blueprint $table)
        {
            $table->dropColumn('duration');
            $table->dropColumn('remote_url');
            $table->string('wistia_id')->nullable();
            $table->string('wistia_hashed_id')->nullable();
            $table->integer('wistia_duration')->nullable();
            $table->string('wistia_thumbnail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos', function(Blueprint $table)
        {
            $table->integer('duration')->nullable();
            $table->string('remote_url')->nullable();
            $table->dropColumn('wistia_id');
            $table->dropColumn('wistia_hashed_id');
            $table->dropColumn('wistia_duration');
            $table->dropColumn('wistia_thumbnail');
        });
    }
}
