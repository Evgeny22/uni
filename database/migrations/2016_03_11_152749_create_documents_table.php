<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('extension');
            $table->string('path');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('author_id')->unsigned();
            $table->integer('documentable_id')->unsigned();
            $table->string('documentable_type');
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
        Schema::drop('documents');
    }
}
