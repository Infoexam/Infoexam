<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Infoexam\Image;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImageController extends Controller {

    public function show($ssn, $small = false)
    {
        $columns = ['image_type', 'public'];

        ($small) ? array_push($columns, 'image_s') : array_push($columns, 'image');

        $image = Image::where('ssn', '=', $ssn)->first($columns);

        if (null === $image)
        {
            throw new NotFoundHttpException;
        }
        else if ( ! $image->public)
        {
            if ( ! \Auth::check())
            {
                throw new AccessDeniedHttpException;
            }
        }

        return response((($small) ? $image->image_s : $image->image))->header('Content-Type', $image->image_type);
    }

    public function show_s($ssn)
    {
        return $this->show($ssn, true);
    }

}