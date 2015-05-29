<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestResultsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('test_results');
        
        Schema::create('test_results', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('test_apply_id')->unsigned();
            $table->longText('record')->nullable();
            $table->float('score', 6, 3)->unsigned()->default(0.0);
            $table->boolean('allow_relogin')->default(false);
            $table->timestamps();

            $table->unique('test_apply_id');

            $table->index('test_apply_id');

            $table->foreign('test_apply_id')->references('id')->on('test_applies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_results', function(Blueprint $table)
        {
            $table->dropForeign('test_results_test_apply_id_foreign');
        });

        Schema::dropIfExists('test_results');
    }

}
