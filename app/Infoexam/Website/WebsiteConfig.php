<?php namespace App\Infoexam\Website;

use App\Infoexam\Core\Entity;

class WebsiteConfig extends Entity {

    protected $fillable = ['student_page_maintain_mode', 'student_page_remark', 'exam_page_maintain_mode', 'exam_page_remark'];

    public $timestamps = false;

}
