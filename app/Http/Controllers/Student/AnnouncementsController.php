<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\Website\Announcement;

class AnnouncementsController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10, ['heading', 'updated_at', 'created_at']);

        return view('student.announcements.index', compact('announcements'));
    }

    public function show($heading)
    {
        if (null === ($announcement = Announcement::where('heading', '=', $heading)->first()))
        {
            return http_404('student.announcements.index');
        }

        $announcement->image_ssn = $this->explode_image_ssn($announcement->image_ssn);

        $title = "{$announcement->heading} :: " . trans('general.title');

        return view('student.announcements.show', compact('title', 'announcement'));
    }
}