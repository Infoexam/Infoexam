<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTestStartedFieldToTestLists extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_lists', function(Blueprint $table)
        {
            $table->boolean('test_started')->default(false);
        });

        DB::statement('ALTER TABLE `test_lists` CHANGE COLUMN `test_started` `test_started` tinyint(1) NOT NULL DEFAULT 0 AFTER `test_enable`');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_lists', function(Blueprint $table)
        {
            $table->dropColumn('test_started');
        });
    }

}
