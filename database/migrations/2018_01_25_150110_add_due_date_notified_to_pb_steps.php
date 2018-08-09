<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDueDateNotifiedToPbSteps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('progress_bar_steps', function (Blueprint $table) {
            $table->integer('due_date_notified')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('progress_bar_steps', function (Blueprint $table) {
            $table->dropColumn('due_date_notified');
        });
    }
}
