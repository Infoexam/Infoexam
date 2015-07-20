<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('test_applies');

        Schema::create('test_applies', function(Blueprint $table)
        {
            $table->increments('id');
            $table->char('ssn', 8);
            $table->integer('account_id')->unsigned();
            $table->integer('test_list_id')->unsigned();
            $table->timestamp('apply_time');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique('ssn');

            $table->index('account_id');
            $table->index('test_list_id');

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('test_list_id')->references('id')->on('test_lists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_applies', function(Blueprint $table)
        {
            $table->dropForeign('test_applies_account_id_foreign');
            $table->dropForeign('test_applies_test_list_id_foreign');
        });

        Schema::dropIfExists('test_applies');
    }
}