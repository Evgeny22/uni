<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDocumentablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function(Blueprint $table)
        {
            $table->dropColumn('documentable_id');
            $table->dropColumn('documentable_type');
        });

        Schema::create('documentables', function(Blueprint $table)
        {
            $table->integer('document_id')->unsigned();
            $table->integer('documentable_id')->unsigned();
            $table->string('documentable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function(Blueprint $table)
        {
            $table->integer('documentable_id')->unsigned();
            $table->string('documentable_type');
        });

        Schema::drop('documentables');
    }
}
