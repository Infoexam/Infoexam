<?php

namespace App\Http\Requests\Student;

use App\Http\Requests\Request;

class MemberInfoRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'g-recaptcha-response' => 'required|recaptcha',
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
            'email.required' => trans('error.required', ['attribute' => trans('general.email')]),
            'email.email' => trans('error.email', ['attribute' => trans('general.email')]),

            'g-recaptcha-response.required' => 'Please ensure that you are a human!',
        ];
    }
}