<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class PaperListsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|between:3,32',
        ];
    }

    /**
     * Set custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => trans('error.required', ['attribute' => trans('paper-lists.name')]),
            'name.between' => trans('error.between', ['attribute' => trans('paper-lists.name'), 'min' => 3, 'max' => 32]),
        ];
    }
}