<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('ip_rules');

        Schema::create('ip_rules', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('ip', 15);
            $table->boolean('student_page')->defalut(true);
            $table->boolean('exam_page')->defalut(false);
            $table->boolean('admin_page')->defalut(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('ip');
            $table->index('student_page');
            $table->index('exam_page');
            $table->index('admin_page');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ip_rules');
    }
}