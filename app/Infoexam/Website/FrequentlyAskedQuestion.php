<?php

namespace App\Infoexam\Website;

use App\Infoexam\Core\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Intervention\Image\Image;

class FrequentlyAskedQuestion extends Entity
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'faqs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['question', 'answer', 'image_ssn'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public static function create(array $attributes = [])
    {
        if (isset($attributes['image']))
        {
            $attributes['image_ssn'] = upload_images($attributes['image'], true);
        }

        return parent::create($attributes);
    }

    public function update(array $attributes = [])
    {
        if (isset($attributes['image']))
        {
            $attributes['image_ssn'] = upload_images($attributes['image'], true);
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