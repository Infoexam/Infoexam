<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePapersQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('papers_questions');
        
        Schema::create('papers_questions', function(Blueprint $table)
        {
            $table->increments('id');
            $table->char('ssn', 8);
            $table->integer('paper_list_id')->unsigned();
            $table->integer('exam_question_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique('ssn');

            $table->index('paper_list_id');
            $table->index('exam_question_id');

            $table->foreign('paper_list_id')->references('id')->on('paper_lists')->onDelete('cascade');
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
        Schema::table('papers_questions', function(Blueprint $table)
        {
            $table->dropForeign('papers_questions_paper_list_id_foreign');
            $table->dropForeign('papers_questions_exam_question_id_foreign');
        });
        
        Schema::dropIfExists('papers_questions');
    }
}