<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsiteConfigsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('website_configs');
        
        Schema::create('website_configs', function(Blueprint $table)
        {
            $table->increments('id');
            $table->boolean('student_page_maintain_mode')->default(false);
            $table->text('student_page_remark')->unsigned();
            $table->boolean('exam_page_maintain_mode')->default(false);
            $table->text('exam_page_remark')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_configs');
    }

}
