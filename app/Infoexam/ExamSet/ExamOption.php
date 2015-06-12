<?php namespace App\Infoexam\ExamSet;

use App\Infoexam\Core\Entity;
use App\Infoexam\Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ExamOption extends Entity {

    use SoftDeletes;

    protected $fillable = ['ssn', 'exam_set_id', 'exam_question_id', 'content', 'image_ssn'];

    protected $dates = ['deleted_at'];

    protected $ssn = true;

    public static function create(array $attributes = [])
    {
        try
        {
            return DB::transaction(function() use ($attributes)
            {
                if (isset($attributes['option']) && isset($attributes['option_image']) && (4 === count($attributes['option'])) && (4 === count($attributes['option_image'])))
                {
                    $data = [
                        'exam_set_id' => $attributes['exam_set_id'],
                        'exam_question_id' => $attributes['exam_question_id']
                    ];

                    for ($i = 0; $i < 4; ++$i)
                    {
                        $images = [];

                        if (isset($attributes['option_image'][$i]))
                        {
                            foreach ($attributes['option_image'][$i] as &$value)
                            {
                                if (null === $value)
                                {
                                    continue;
                                }

                                $image = new Image();

                                $image = $image->uploadImage($value);

                                if ($image->exists)
                                {
                                    $images[] = $image->ssn;
                                }
                            }
                        }

                        $data['content'] = $attributes['option'][$i];
                        $data['image_ssn'] = count($images) ? implode(',', $images) : null;

                        if ( ! parent::create($data)->exists)
                        {
                            throw new ModelNotFoundException;
                        }

                        unset($images, $image);
                    }

                    return true;
                }

                return false;
            });
        }
        catch (ModelNotFoundException $e)
        {
            return false;
        }
    }

    public static function updates(array $attributes = [])
    {
        if (isset($attributes['option_ssn']) && isset($attributes['option']) && isset($attributes['option_image_ssn']) && isset($attributes['option_image']))
        {
            foreach ($attributes['option_ssn'] as $index => $ssn)
            {
                if (null !== ($option = ExamOption::where('ssn', '=', $ssn)->first()))
                {
                    if (isset($attributes['option_image'][$index]))
                    {
                        Image::whereIn('ssn', explode(',', $attributes['option_image_ssn'][$index]))->delete();
                    }

                    $images = [];

                    if (isset($attributes['option_image'][$index]))
                    {
                        foreach ($attributes['option_image'][$index] as $value)
                        {
                            if (null === $value)
                            {
                                continue;
                            }

                            $image = new Image();

                            $image = $image->uploadImage($value);

                            if ($image->exists)
                            {
                                $images[] = $image->ssn;
                            }
                        }
                    }

                    $option->update([
                        'content' => $attributes['option'][$index],
                        'image_ssn' => count($images) ? implode(',', $images) : null
                    ]);
                }
            }

            return true;
        }

        return false;
    }

    public function delete()
    {
        if (null !== ($image_ssn = $this->image_ssn))
        {
            Image::destroy($image_ssn);
        }

        return parent::delete();
    }

}
