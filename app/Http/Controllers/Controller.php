<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    public function explode_collections_image_ssn(&$collections)
    {
        foreach ($collections as &$collection)
        {
            $collection->image_ssn = $this->explode_image_ssn($collection->image_ssn);
        }
    }

    public function explode_image_ssn($image_ssn)
    {
        return (null === $image_ssn && ! is_string($image_ssn)) ? null : explode(',', $image_ssn);
    }
}
