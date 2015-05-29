<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGroupsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('user_groups');
        
        Schema::create('user_groups', function(Blueprint $table)
        {
            $table->integer('account_id')->unsigned();
            $table->integer('group_id')->unsigned();

            $table->primary(['account_id', 'group_id']);

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_groups', function(Blueprint $table)
        {
            $table->dropForeign('user_groups_account_id_foreign');
            $table->dropForeign('user_groups_group_id_foreign');
        });

        Schema::dropIfExists('user_groups');
    }

}
