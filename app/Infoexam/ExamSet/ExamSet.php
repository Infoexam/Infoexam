<?php namespace App\Infoexam\ExamSet;

use App\Infoexam\Core\Entity;
use App\Infoexam\Image;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamSet extends Entity {

    use SoftDeletes;

    protected $fillable = ['ssn', 'name', 'category', 'set_enable', 'open_practice'];

    protected $dates = ['deleted_at'];

    protected $ssn = true;

    public function tags()
    {
        return $this->belongsToMany('\App\Infoexam\ExamSet\ExamSetTag', 'exam_set_exam_set_tags');
    }

    public function questions()
    {
        return $this->hasMany('App\Infoexam\ExamSet\ExamQuestion')
            ->select(['id', 'ssn', 'exam_set_id', 'topic', 'level', 'multiple', 'image_ssn', 'answer', 'explanation']);
    }

    public function options()
    {
        return $this->hasMany('App\Infoexam\ExamSet\ExamOption')
            ->select(['ssn', 'exam_set_id', 'exam_question_id', 'content', 'image_ssn']);
    }

    public function getExamSetTagListAttribute()
    {
        return $this->tags->lists('id')->all();
    }

    public function syncTags(array $tags = [])
    {
        $this->tags()->sync($tags);
    }

    public function scopeSetEnable($query, $param = true)
    {
        $query->where('set_enable', '=', $param);
    }

    public static function create(array $attributes = [])
    {
        $model = parent::create($attributes);

        /*
         * 如果新建成功且有選擇標籤，則同步之
         */
        if ($model->exists && isset($attributes['exam_set_tag_list']))
        {
            $s = $attributes['exam_set_tag_list'];

            $tags = (is_array($s) && count($s)) ? $s : [];

            $model->syncTags($tags);
        }

        return $model;
    }

    public function delete()
    {
        /*
         * 刪除該題庫之所有選項
         */
        $options = ExamOption::where('exam_set_id', '=', $this->id)->get(['id', 'image_ssn'])->toArray();

        ExamOption::whereIn('id', array_column($options, 'id'))->delete();

        /*
         * 刪除該題庫之所有題目
         */
        $questions = ExamQuestion::where('exam_set_id', '=', $this->id)->get(['id', 'image_ssn'])->toArray();

        ExamQuestion::whereIn('id', array_column($questions, 'id'))->delete();

        /*
         * 刪除題庫之所有圖片
         */
        $images = array_merge(array_column($options, 'image_ssn'), array_column($questions, 'image_ssn'));

        Image::whereIn('ssn', $images)->delete();

        return parent::delete();
    }

}
