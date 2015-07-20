<?php

namespace App\Infoexam\Website;

use App\Infoexam\Core\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;

class IpRule extends Entity
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ip', 'student_page', 'exam_page', 'admin_page'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}