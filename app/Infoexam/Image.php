<?php

namespace App\Infoexam;

use App\Infoexam\Core\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Intervention\Image\Facades\Image as Imager;

class Image extends Entity
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ssn', 'image_type', 'public', 'original_path', 'thumbnail_path'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $ssn = true;

    public function uploadImages(array $files = [], $public = false)
    {
        if ( ! count($files))
        {
            return null;
        }

        $images = [];

        foreach ($files as $file)
        {
            $model = $this->uploadImage($file, $public);

            if (null !== $model && $model->exists)
            {
                $images[] = $model->attributes['ssn'];
            }
        }

        return (count($images)) ? implode(',', $images) : null;
    }

    public function uploadImage($file = null, $public = false)
    {
        if (null === $file || ! $file->isValid())
        {
            return null;
        }

        while (\File::exists(image_path(($original_path = str_random(16)))))
        {
            ;
        }

        $thumbnail_path = $this->createMiniature($file);

        $image['original_path'] = $original_path;
        $image['thumbnail_path'] = $thumbnail_path;
        $image['image_type'] = $file->getMimeType();
        $image['public'] = $public;

        $file->move(image_path(), $original_path);

        return $this->create($image);
    }

    public function createMiniature($file)
    {
        while (\File::exists(image_thumbnail_path(($thumbnail_path = str_random(16)))))
        {
            ;
        }

        Imager::make($file->getRealPath())
            ->resize(360, 240, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save(image_thumbnail_path($thumbnail_path));

        return $thumbnail_path;
    }
}