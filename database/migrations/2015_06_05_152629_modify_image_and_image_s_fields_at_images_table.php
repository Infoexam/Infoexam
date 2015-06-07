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
        });

        DB::statement('ALTER TABLE `images` MODIFY `original_path` CHAR(16) NOT NULL');
        DB::statement('ALTER TABLE `images` MODIFY `thumbnail_path` CHAR(16) NOT NULL');
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
