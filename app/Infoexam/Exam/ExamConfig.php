<?php namespace App\Infoexam\Exam;

use App\Infoexam\Core\Entity;

class ExamConfig extends Entity {

    protected $fillable = ['open_room', 'acad_passed_score', 'tech_passed_score', 'latest_cancel_apply_day', 'free_apply_grade'];

    public $timestamps = false;

}