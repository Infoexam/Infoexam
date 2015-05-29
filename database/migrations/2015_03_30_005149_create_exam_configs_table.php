<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamConfigsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('exam_configs');
        
        Schema::create('exam_configs', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('open_room');
            $table->tinyInteger('acad_passed_score')->unsigned()->default(70);
            $table->tinyInteger('tech_passed_score')->unsigned()->default(70);
            $table->tinyInteger('latest_cancel_apply_day')->unsigned()->default(1);
            $table->tinyInteger('free_apply_grade')->unsigned()->default(2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_configs');
    }

}
