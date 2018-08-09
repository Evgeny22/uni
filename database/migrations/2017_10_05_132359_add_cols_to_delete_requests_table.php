<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsToDeleteRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delete_requests', function (Blueprint $table) {
            $table->integer('deleter_id');
            $table->integer('approved');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delete_requests', function (Blueprint $table) {
            $table->dropColumn('deleter_id');
            $table->dropColumn('approved');
        });
    }
}
