<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Infoexam\Image;
use Carbon\Carbon;
use File;
use Illuminate\Auth\Guard;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImageController extends Controller
{
    protected $guard;

    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    public function show($ssn, $small = false)
    {
        if (null === ($image = Image::ssn($ssn)->first()))
        {
            throw new NotFoundHttpException;
        }
        else if (( ! $image->public) && ($this->guard->guest()))
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