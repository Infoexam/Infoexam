<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('faqs');

        Schema::create('faqs', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('question');
            $table->text('answer');
            $table->string('image_ssn')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('question');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faqs');
    }
}