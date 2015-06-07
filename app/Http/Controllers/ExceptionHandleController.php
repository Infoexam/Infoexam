<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ExceptionHandleController extends Controller {

    public function noscript()
    {
        return view('errors.503');
    }

}
