<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRejectedReasonToExemplarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exemplars', function(Blueprint $table)
        {
            $table->dropColumn('approved');
        });
        Schema::table('exemplars', function (Blueprint $table) {
            $table->string('rejected_reason')->nullable();
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
        Schema::table('exemplars', function (Blueprint $table) {
            $table->dropColumn('rejected_reason');
            $table->dropColumn('approved');
        });
        Schema::table('exemplars', function (Blueprint $table) {
            $table->boolean('approved');
        });
        
    }
}
