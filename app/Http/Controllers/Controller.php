<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

    use DispatchesCommands, ValidatesRequests;

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
