<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\Website\Announcement;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AnnouncementsController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderBy('id', 'desc')->paginate(10, ['heading', 'updated_at', 'created_at']);

        return view('student.announcements.index', compact('announcements'));
    }

    public function show($heading)
    {
        if (null === ($announcement = Announcement::where('heading', '=', $heading)->first()))
        {
            return http_404('student.announcements.index');
        }

        $announcement->image_ssn = $this->explode_image_ssn($announcement->image_ssn);

        $title = trans('general.title').' :: '.$announcement->heading;

        return view('student.announcements.show', compact('title', 'announcement'));
    }
}