<?php namespace App\Infoexam;

use App\Infoexam\Core\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Intervention\Image\Facades\Image as Imager;

class Image extends Entity {

    use SoftDeletes;

    protected $fillable = ['ssn', 'image_type', 'public', 'image', 'image_s'];

    protected $dates = ['deleted_at'];

    protected $ssn = true;

    public function uploadImage($file = null, $public = false)
    {
        if (null === $file)
        {
            return null;
        }

        $image['image'] = file_get_contents($file->getRealPath());
        $image['image_s'] = file_get_contents($path = $this->createMiniature($file));
        $image['image_type'] = $file->getMimeType();
        $image['public'] = $public;

        $model = $this->create($image);

        unlink($path);

        return $model;
    }

    public function uploadImages(array $files = [], $public = false)
    {
        if ( ! count($files))
        {
            return null;
        }

        $images = [];

        foreach ($files as &$file)
        {
            if (null === $file)
            {
                continue;
            }

            $image['image'] = file_get_contents($file->getRealPath());
            $image['image_s'] = file_get_contents($path = $this->createMiniature($file));
            $image['image_type'] = $file->getMimeType();
            $image['public'] = $public;

            $model = $this->create($image);

            unlink($path);

            if ($model->exists)
            {
                $images[] = $model->attributes['ssn'];
            }
        }

        return (count($images)) ? implode(',', $images) : null;
    }

    public function createMiniature($file)
    {
        $path = temp_path(str_random(5));

        Imager::make($file->getRealPath())
            ->resize(360, 240, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save($path);

        return $path;
    }
}
