<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamOptionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('exam_options');

        Schema::create('exam_options', function(Blueprint $table)
        {
            $table->increments('id');
            $table->char('ssn', 8);
            $table->integer('exam_set_id')->unsigned();
            $table->integer('exam_question_id')->unsigned();
            $table->longText('content')->nullable();
            $table->string('image_ssn')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique('ssn');

            $table->index('ssn');
            $table->index('exam_set_id');
            $table->index('exam_question_id');

            $table->foreign('exam_set_id')->references('id')->on('exam_sets')->onDelete('cascade');
            $table->foreign('exam_question_id')->references('id')->on('exam_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_options', function(Blueprint $table)
        {
            $table->dropForeign('exam_options_exam_set_id_foreign');
            $table->dropForeign('exam_options_exam_question_id_foreign');
        });

        Schema::dropIfExists('exam_options');
    }

}
