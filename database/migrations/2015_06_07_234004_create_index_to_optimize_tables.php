<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndexToOptimizeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accredited_data', function(Blueprint $table)
        {
            $table->index('is_passed');
        });

        Schema::table('images', function(Blueprint $table)
        {
            $table->index('deleted_at');
        });

        Schema::table('ip_rules', function(Blueprint $table)
        {
            $table->index('deleted_at');
        });

        Schema::table('exam_sets', function(Blueprint $table)
        {
            $table->index('set_enable');
            $table->index('open_practice');
            $table->index('deleted_at');
        });

        Schema::table('exam_questions', function(Blueprint $table)
        {
            $table->index('deleted_at');
        });

        Schema::table('exam_options', function(Blueprint $table)
        {
            $table->index('deleted_at');
        });

        Schema::table('paper_lists', function(Blueprint $table)
        {
            $table->index('auto_generate');
            $table->index('deleted_at');
        });

        Schema::table('papers_questions', function(Blueprint $table)
        {
            $table->index('deleted_at');
        });

        Schema::table('announcements', function(Blueprint $table)
        {
            $table->index('deleted_at');
        });

        Schema::table('groups', function(Blueprint $table)
        {
            $table->index('deleted_at');
        });

        Schema::table('test_lists', function(Blueprint $table)
        {
            $table->index('end_time');
            $table->index('allow_apply');
            $table->index('test_enable');
            $table->index('test_started');
            $table->index('deleted_at');
        });

        Schema::table('test_applies', function(Blueprint $table)
        {
            $table->index('apply_time');
            $table->index('deleted_at');
        });

        Schema::table('test_results', function(Blueprint $table)
        {
            $table->index('score');
        });

        Schema::table('activity_log', function(Blueprint $table)
        {
            $table->index('user_id');
            $table->index('text');
            $table->index('ip_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accredited_data', function(Blueprint $table)
        {
            $table->dropIndex('accredited_data_is_passed_index');
        });

        Schema::table('images', function(Blueprint $table)
        {
            $table->dropIndex('images_deleted_at_index');
        });

        Schema::table('ip_rules', function(Blueprint $table)
        {
            $table->dropIndex('ip_rules_deleted_at_index');
        });

        Schema::table('exam_sets', function(Blueprint $table)
        {
            $table->dropIndex('exam_sets_set_enable_index');
            $table->dropIndex('exam_sets_open_practice_index');
            $table->dropIndex('exam_sets_deleted_at_index');
        });

        Schema::table('exam_questions', function(Blueprint $table)
        {
            $table->dropIndex('exam_questions_deleted_at_index');
        });

        Schema::table('exam_options', function(Blueprint $table)
        {
            $table->dropIndex('exam_options_deleted_at_index');
        });

        Schema::table('paper_lists', function(Blueprint $table)
        {
            $table->dropIndex('paper_lists_auto_generate_index');
            $table->dropIndex('paper_lists_deleted_at_index');
        });

        Schema::table('papers_questions', function(Blueprint $table)
        {
            $table->dropIndex('papers_questions_deleted_at_index');
        });

        Schema::table('announcements', function(Blueprint $table)
        {
            $table->dropIndex('announcements_deleted_at_index');
        });

        Schema::table('groups', function(Blueprint $table)
        {
            $table->dropIndex('groups_deleted_at_index');
        });

        Schema::table('test_lists', function(Blueprint $table)
        {
            $table->dropIndex('test_lists_end_time_index');
            $table->dropIndex('test_lists_allow_apply_index');
            $table->dropIndex('test_lists_test_enable_index');
            $table->dropIndex('test_lists_test_started_index');
            $table->dropIndex('test_lists_deleted_at_index');
        });

        Schema::table('test_applies', function(Blueprint $table)
        {
            $table->dropIndex('test_applies_apply_time_index');
            $table->dropIndex('test_applies_deleted_at_index');
        });

        Schema::table('test_results', function(Blueprint $table)
        {
            $table->dropIndex('test_results_score_index');
        });

        Schema::table('activity_log', function(Blueprint $table)
        {
            $table->dropIndex('activity_log_user_id_index');
            $table->dropIndex('activity_log_text_index');
            $table->dropIndex('activity_log_ip_address_index');
        });
    }
}