<?php namespace App\Infoexam\ExamSet;

use App\Infoexam\Core\Entity;

class ExamSetTag extends Entity {

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];

    public function exam_sets()
    {
        return $this->belongsToMany('\App\Infoexam\ExamSet\ExamSet', 'exam_set_exam_set_tags');
    }

}
