<?php

namespace App\Infoexam\Test;

use App\Infoexam\Core\Entity;

class TestResult extends Entity
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['test_apply_id', 'record', 'score', 'allow_relogin', 'exam_time_extends'];

    /**
     * Indicates whether show the flash message.
     *
     * @var bool
     */
    protected $showRemind = false;
}