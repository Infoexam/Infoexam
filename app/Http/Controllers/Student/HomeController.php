<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\Test\TestList;
use App\Infoexam\Website\Announcement;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->take(5)->get(['heading', 'created_at']);

        $test_lists = TestList::where('start_time', '>=', Carbon::now())->take(6)->get(['room', 'test_type', 'start_time']);

        return view('student.index', compact('announcements', 'test_lists'));
    }
}