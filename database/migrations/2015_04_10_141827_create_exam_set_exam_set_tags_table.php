<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamSetExamSetTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('exam_set_exam_set_tags');

        Schema::create('exam_set_exam_set_tags', function(Blueprint $table)
        {
            $table->integer('exam_set_id')->unsigned();
            $table->integer('exam_set_tag_id')->unsigned();

            $table->primary(['exam_set_id', 'exam_set_tag_id']);

            $table->foreign('exam_set_id')->references('id')->on('exam_sets')->onDelete('cascade');
            $table->foreign('exam_set_tag_id')->references('id')->on('exam_set_tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_set_exam_set_tags', function(Blueprint $table)
        {
            $table->dropForeign('exam_set_exam_set_tags_exam_set_id_foreign');
            $table->dropForeign('exam_set_exam_set_tags_exam_set_tag_id_foreign');
        });

        Schema::dropIfExists('exam_set_exam_set_tags');
    }
}