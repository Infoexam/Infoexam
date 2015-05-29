<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamQuestionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('exam_questions');

        Schema::create('exam_questions', function(Blueprint $table)
        {
            $table->increments('id');
            $table->char('ssn', 6);
            $table->integer('exam_set_id')->unsigned();
            $table->longText('topic');
            $table->tinyInteger('level')->default(2);
            $table->boolean('multiple')->default(false);
            $table->string('image_ssn')->nullable();
            $table->string('answer');
            $table->timestamps();
            $table->softDeletes();

            $table->unique('ssn');

            $table->index('ssn');
            $table->index('exam_set_id');
            $table->index('level');
            $table->index('multiple');

            $table->foreign('exam_set_id')->references('id')->on('exam_sets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_questions', function(Blueprint $table)
        {
            $table->dropForeign('exam_questions_exam_set_id_foreign');
        });

        Schema::dropIfExists('exam_questions');
    }

}
