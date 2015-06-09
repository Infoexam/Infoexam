<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Infoexam\Image;
use Carbon\Carbon;
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

        $prepare_headers = [
            'Content-Length' => File::size($path),
            'Content-Type' => $image->image_type,
        ];

        $response = response(File::get($path), 200, $prepare_headers);

        $response->setLastModified(Carbon::createFromTimestamp(File::lastModified($path)));

        $response->setEtag(sha1_file($path));

        $response->headers->remove('Cache-Control');

        return $response;
    }

    public function show_s($ssn)
    {
        return $this->show($ssn, true);
    }
}