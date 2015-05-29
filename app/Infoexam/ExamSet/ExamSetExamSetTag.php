<?php namespace App\Infoexam\ExamSet;

use App\Infoexam\Core\Entity;

class ExamSetExamSetTag extends Entity {

    protected $fillable = ['exam_set_id', 'exam_set_tag_id'];

    public $timestamps = false;

}
