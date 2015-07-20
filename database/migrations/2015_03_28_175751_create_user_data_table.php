<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('user_data');
        
        Schema::create('user_data', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('account_id')->unsigned();
            $table->string('name', 16);
            $table->char('id_number', 10);
            $table->char('gender', 1);
            $table->string('email');
            $table->tinyInteger('grade')->unsigned();
            $table->char('class', 1)->default('A');
            $table->integer('department_id')->unsigned();
            $table->timestamps();

            $table->index('account_id');
            $table->index('id_number');
            $table->index('name');
            $table->index('grade');
            $table->index('department_id');

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_data', function(Blueprint $table)
        {
            $table->dropForeign('user_data_account_id_foreign');
            $table->dropForeign('user_data_department_id_foreign');
        });

        Schema::dropIfExists('user_data');
    }
}