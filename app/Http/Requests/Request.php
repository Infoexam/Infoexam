<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Determine if the request passes the authorization check.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Convert the input value to bool type.
     *
     * @param array $lists
     * @return void
     */
    public function setBool(array $lists = [])
    {
        if (count($lists))
        {
            $replace = [];

            foreach ($lists as &$list)
            {
                $replace[$list] = (bool) $this->input($list, false);
            }

            $this->merge($replace);
        }
    }
}