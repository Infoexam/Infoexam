<?php

namespace App\Infoexam\ExamSet;

use App\Infoexam\Core\Entity;

class ExamSetTag extends Entity
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public function exam_sets()
    {
        return $this->belongsToMany('\App\Infoexam\ExamSet\ExamSet', 'exam_set_exam_set_tags')
            ->select(['id', 'ssn', 'name', 'category']);
    }
}