<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Infoexam\Image;
use File;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImageController extends Controller {

    public function show($ssn, $small = false)
    {
        $image = Image::where('ssn', '=', $ssn)->first();

        if (null === $image)
        {
            throw new NotFoundHttpException;
        }
        else if ( ! $image->public && ! \Auth::check())
        {
            throw new AccessDeniedHttpException;
        }

        $path = ($small) ? image_thumbnail_path($image->thumbnail_path) : image_path($image->original_path);

        if ( ! File::exists($path))
        {
            throw new NotFoundHttpException;
        }

        return response(File::get($path))->header('Content-Type', $image->image_type);
    }

    public function show_s($ssn)
    {
        return $this->show($ssn, true);
    }

}