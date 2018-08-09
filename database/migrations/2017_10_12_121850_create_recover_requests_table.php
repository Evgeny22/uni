<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecoverRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recover_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('author_id');
            $table->string('object_id');
            $table->string('object_type');
            $table->integer('recoverer_id');
            $table->integer('approved');
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
        Schema::drop('recover_requests');
    }
}
