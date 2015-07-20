<?php

namespace App\Infoexam\ExamSet;

use App\Infoexam\Core\Entity;

class ExamSetExamSetTag extends Entity
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['exam_set_id', 'exam_set_tag_id'];
}