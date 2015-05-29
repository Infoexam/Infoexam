<?php namespace App\Infoexam\Website;

use App\Infoexam\Core\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;

class IpRule extends Entity {

    use SoftDeletes;

    protected $fillable = ['ip', 'student_page', 'exam_page', 'admin_page'];

    protected $dates = ['deleted_at'];
}
