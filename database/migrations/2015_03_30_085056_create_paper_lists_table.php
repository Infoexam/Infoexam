<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaperListsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('paper_lists');
        
        Schema::create('paper_lists', function(Blueprint $table)
        {
            $table->increments('id');
            $table->char('ssn', 6);
            $table->string('name', 64);
            $table->text('remark')->nullable();
            $table->boolean('auto_generate')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->unique('ssn');

            $table->index('ssn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paper_lists');
    }

}
