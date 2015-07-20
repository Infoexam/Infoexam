<?php

namespace App\Infoexam\ExamSet;

use App\Infoexam\Core\Entity;
use App\Infoexam\Image;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamQuestion extends Entity
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ssn', 'exam_set_id', 'topic', 'level', 'multiple', 'image_ssn', 'answer', 'explanation'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $ssn = true;

    public function options()
    {
        return $this->hasMany('App\Infoexam\ExamSet\ExamOption')
            ->select(['ssn', 'exam_set_id', 'exam_question_id', 'content', 'image_ssn']);
    }

    public function exam_set()
    {
        return $this->belongsTo('App\Infoexam\ExamSet\ExamSet');
    }

    public static function create(array $attributes = [])
    {
        /*
         * 取得 exam set 的 id
         */
        $exam_set_id = ExamSet::where('ssn', '=', $attributes['exam_set_ssn'])->first(['id']);

        if (null === $exam_set_id)
        {
            return false;
        }

        $attributes['exam_set_id'] = $exam_set_id->id;

        if (isset($attributes['topic_image']))
        {
            $image = new Image();

            $image = $image->uploadImage($attributes['topic_image']);

            if ($image->exists)
            {
                $attributes['image_ssn'] = $image->ssn;
            }
        }

        $attributes['answer'] = serialize($attributes['answer']);

        $model = parent::create($attributes);

        if ( ! $model->exists)
        {
            if (isset($attributes['image_ssn']))
            {
                $image->delete();
            }
        }
        else
        {
            unset($attributes['topic'], $attributes['explanation'], $attributes['level'], $attributes['multiple'], $attributes['answer'], $attributes['topic_image'], $attributes['image_ssn']);

            $attributes['exam_question_id'] = $model->id;

            if ( ! ExamOption::create($attributes))
            {
                $model->delete();

                if (isset($attributes['image_ssn']))
                {
                    $image->delete();
                }
            }
        }

        return $model;
    }

    public function update(array $attributes = [])
    {
        if (isset($attributes['topic_image']))
        {
            if (null !== $this->image_ssn)
            {
                Image::where('ssn', '=', $this->image_ssn)->delete();
            }

            $image = new Image();

            $image = $image->uploadImage($attributes['topic_image']);

            $attributes['image_ssn'] = ($image->exists) ? $image->ssn : null;
        }

        $attributes['answer'] = serialize($attributes['answer']);

        return parent::update($attributes);
    }

    public function delete()
    {
        /*
         * 刪除該題目之所有選項
         */
        $options = ExamOption::where('exam_question_id', '=', $this->id)->get(['id', 'image_ssn'])->toArray();

        ExamOption::whereIn('id', array_column($options, 'id'))->delete();

        /*
         * 取得該題目之題片
         */
        $questions = (null === $this->image_ssn) ? [] : [$this->image_ssn];

        /*
         * 刪除題庫之所有圖片
         */
        $images = array_merge(array_column($options, 'image_ssn'), $questions);

        Image::whereIn('ssn', $images)->delete();

        return parent::delete();
    }
}