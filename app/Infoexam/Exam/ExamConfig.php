<?php

namespace App\Infoexam\Exam;

use App\Infoexam\Core\Entity;

class ExamConfig extends Entity
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
    protected $fillable = ['open_room', 'acad_passed_score', 'tech_passed_score', 'latest_cancel_apply_day', 'free_apply_grade'];
}