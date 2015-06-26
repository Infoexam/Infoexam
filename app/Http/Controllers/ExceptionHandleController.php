<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class ExceptionHandleController extends Controller
{
    public function noscript()
    {
        return view('errors.503');
    }

    public function browserNotSupport()
    {
        return view('errors.browserNotSupport');
    }
}
