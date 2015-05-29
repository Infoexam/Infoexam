<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTestResultIdFieldToTestApplies extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_applies', function(Blueprint $table)
        {
            $table->integer('test_result_id')->unsigned()->nullable();

            $table->index('test_result_id');

            $table->foreign('test_result_id')->references('id')->on('test_results')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_applies', function(Blueprint $table)
        {
            $table->dropForeign('test_applies_test_result_id_foreign');
        });
    }

}
