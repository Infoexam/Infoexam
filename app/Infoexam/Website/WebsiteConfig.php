<?php

namespace App\Infoexam\Website;

use App\Infoexam\Core\Entity;

class WebsiteConfig extends Entity
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
    protected $fillable = ['student_page_maintain_mode', 'student_page_remark', 'exam_page_maintain_mode', 'exam_page_remark'];
}