<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('receipts');

        Schema::create('receipts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('receipt_no', 16);
            $table->string('receipt_date', 8);
            $table->integer('account_id')->unsigned();
            $table->tinyInteger('type')->unsigned()->nullable();
            $table->timestamps();

            $table->unique('receipt_no');

            $table->index('account_id');
            $table->index('type');

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
        Schema::table('receipts', function(Blueprint $table)
        {
            $table->dropForeign('receipts_account_id_foreign');
        });

        Schema::dropIfExists('receipts');
    }
}