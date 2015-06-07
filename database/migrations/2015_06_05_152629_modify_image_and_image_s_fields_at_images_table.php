<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyImageAndImageSFieldsAtImagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function(Blueprint $table)
        {
            $table->renameColumn('image', 'original_path');
            $table->renameColumn('image_s', 'thumbnail_path');

            $table->char('original_path', 16)->change();
            $table->char('thumbnail_path', 16)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function(Blueprint $table)
        {
            $table->renameColumn('original_path', 'image');
            $table->renameColumn('thumbnail_path', 'image_s');
        });

        DB::statement('ALTER TABLE `images` MODIFY `image` LONGBLOB');
        DB::statement('ALTER TABLE `images` MODIFY `image_s` LONGBLOB');
    }

}
