<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestListsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('test_lists');
        
        Schema::create('test_lists', function(Blueprint $table)
        {
            $table->increments('id');
            $table->char('ssn', 13);
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->string('room', 8);
            $table->string('apply_type', 8);
            $table->string('test_type', 8);
            $table->tinyInteger('std_num_limit')->unsigned();
            $table->tinyInteger('std_apply_num')->unsigned()->default(0);
            $table->tinyInteger('std_real_test_num')->unsigned()->default(0);
            $table->integer('paper_list_id')->unsigned()->nullable();
            $table->boolean('allow_apply')->default(false);
            $table->boolean('test_enable')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->unique('ssn');

            $table->index('ssn');
            $table->index('start_time');
            $table->index('room');
            $table->index('apply_type');
            $table->index('test_type');
            $table->index('paper_list_id');

            $table->foreign('paper_list_id')->references('id')->on('paper_lists')->onDelete('cascade');
        });
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
            $table->dropForeign('test_lists_paper_list_id_foreign');
        });

        Schema::dropIfExists('test_lists');
    }

}
