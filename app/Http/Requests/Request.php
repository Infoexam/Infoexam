<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest {

    public function authorize()
    {
        return true;
    }

    protected function boolean_parsing(array $lists = [])
    {
        if (is_array($lists) && count($lists))
        {
            foreach ($lists as $list)
            {
                $this->merge([$list => (boolean) $this->input($list, false)]);
            }
        }
    }

}