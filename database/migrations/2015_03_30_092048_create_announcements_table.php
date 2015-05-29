<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('announcements');
        
        Schema::create('announcements', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('heading');
            $table->string('link')->nullable();
            $table->longText('content');
            $table->string('image_ssn')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique('heading');

            $table->index('heading');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcements');
    }

}
