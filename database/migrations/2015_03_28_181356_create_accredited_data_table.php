<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccreditedDataTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('accredited_data');
        
        Schema::create('accredited_data', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('account_id')->unsigned();
            $table->tinyInteger('free_acad')->default(1);
            $table->tinyInteger('free_tech')->default(1);
            $table->boolean('is_passed')->default(false);
            $table->tinyInteger('passed_score')->unsigned()->nullable();
            $table->tinyInteger('passed_year')->unsigned()->nullable();
            $table->tinyInteger('passed_semester')->unsigned()->nullable();
            $table->timestamp('passed_time')->nullable();
            $table->tinyInteger('acad_score')->unsigned()->nullable();
            $table->tinyInteger('tech_score')->unsigned()->nullable();
            $table->tinyInteger('test_count')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
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
            $table->dropForeign('accredited_data_account_id_foreign');
        });

        Schema::dropIfExists('accredited_data');
    }

}
