<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests;

class HomeController extends Controller
{
    public function index()
    {
        return view('student.index');
    }
}