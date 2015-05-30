<?php namespace App\Infoexam\Website;

use App\Infoexam\Core\Entity;
use App\Infoexam\Image;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Entity {

    use SoftDeletes;

    protected $fillable = ['heading', 'link', 'content', 'image_ssn'];

    protected $dates = ['deleted_at'];

    public static function create(array $attributes = [])
    {
        if (isset($attributes['image']))
        {
            $attributes['image_ssn'] = upload_images($attributes['image']);
        }

        return parent::create($attributes);
    }

    public function update(array $attributes = [])
    {
        if (isset($attributes['image']))
        {
            $attributes['image_ssn'] = upload_images($attributes['image']);
        }

        return parent::update($attributes);
    }

    public function delete()
    {
        if (null !== $this->image_ssn)
        {
            Image::whereIn('ssn', explode(',', $this->image_ssn))->delete();

            $this->update(['image_ssn' => null]);
        }

        return parent::delete();
    }

}