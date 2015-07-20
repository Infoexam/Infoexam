<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExplanationFieldToExamQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_questions', function(Blueprint $table)
        {
            $table->longText('explanation')->nullable();
        });

        DB::statement('ALTER TABLE `exam_questions` CHANGE COLUMN `explanation` `explanation` longtext AFTER `answer`');
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
            $table->dropColumn('explanation');
        });
    }
}