<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Rap2hpoutre\LaravelLogViewer\LaravelLogViewer;

class LogViewerController extends Controller {

    public function index()
    {
        if ( ! is_null($filename = \Request::get('l')))
        {
            LaravelLogViewer::setFile(base64_decode($filename));
        }

        $logs = LaravelLogViewer::all();

        return view('admin.logs', [
            'logs' => $logs,
            'files' => LaravelLogViewer::getFiles(true),
            'current_file' => LaravelLogViewer::getFileName()
        ]);
    }

}
