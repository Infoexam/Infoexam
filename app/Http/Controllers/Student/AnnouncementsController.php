<?php namespace App\Http\Controllers\Student;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Infoexam\Website\Announcement;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AnnouncementsController extends Controller {


    public function index()
    {
        $announcements = Announcement::orderBy('id', 'desc')->paginate(10);

        return view('student.announcements.index', compact('announcements'));
    }

    public function show($heading)
    {
        try
        {
            $announcement = Announcement::where('heading', '=', $heading)->firstOrFail();
            $announcement->image_ssn = (is_null($announcement->image_ssn)) ? null : explode(',', $announcement->image_ssn);
            $title = trans('general.title').' :: '.$announcement->heading;

            return view('student.announcements.show', compact('title', 'announcement'));
        }
        catch (ModelNotFoundException $e)
        {
            throw new NotFoundHttpException;
        }
    }

}