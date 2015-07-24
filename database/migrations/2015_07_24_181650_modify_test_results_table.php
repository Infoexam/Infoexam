<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_results', function (Blueprint $table)
        {
            $table->tinyInteger('exam_time_extends')->unsigned()->default(0)->after('allow_relogin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_results', function (Blueprint $table)
        {
            $table->dropColumn('exam_time_extends');
        });
    }
}