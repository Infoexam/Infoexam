<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('images');

        Schema::create('images', function(Blueprint $table)
        {
            $table->char('ssn', 8);
            $table->string('image_type', 32);
            $table->boolean('public')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->primary('image_key');
        });

        DB::statement('ALTER TABLE `images` ADD  `image` LONGBLOB AFTER `public`');
        DB::statement('ALTER TABLE `images` ADD  `image_s` LONGBLOB AFTER `image`');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }

}
