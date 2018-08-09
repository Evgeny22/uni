<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExemplarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exemplars', function (Blueprint $table)
        {
            $table->increments('id');
            $table->text('reason');
            $table->integer('author_id')->unsigned();
            $table->boolean('approved')->default(false);
            $table->integer('approver_id')->unsigned();
            $table->integer('exemplarable_id')->unsigned();
            $table->string('exemplarable_type');
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
        Schema::drop('exemplars');
    }
}
