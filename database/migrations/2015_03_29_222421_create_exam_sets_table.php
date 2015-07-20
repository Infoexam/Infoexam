<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('exam_sets');

        Schema::create('exam_sets', function(Blueprint $table)
        {
            $table->increments('id');
            $table->char('ssn', 4);
            $table->string('name', 32);
            $table->char('category', 1)->default('A');
            $table->boolean('set_enable')->default(false);
            $table->boolean('open_practice')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->unique('ssn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_sets');
    }
}