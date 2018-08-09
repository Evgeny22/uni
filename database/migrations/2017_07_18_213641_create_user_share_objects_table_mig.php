<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserShareObjectsTableMig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_share_objects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_share_id');
            $table->integer('object_id');
            $table->string('object_type', '255');
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
        Schema::drop('user_share_objects');
    }
}
