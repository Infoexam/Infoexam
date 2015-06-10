<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;

class LogViewerController extends Controller
{
    public function index()
    {
        return view('admin.logs');
    }
}
