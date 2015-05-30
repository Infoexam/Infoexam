<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class StudentInformationRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'new_password' => 'confirmed',
            'group_list' => 'exists:groups,id',
            'name' => 'required|between:2,32',
            'email' => 'required|email',
            'free_acad' => 'required|digits_between:0,127',
            'free_tech' => 'required|digits_between:0,127',
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
            'new_password.confirmed' => 'The new password and new password confirmed fields are not equal.',

            'group_list.exists' => trans('error.exists', ['attribute' => trans('student-information.groups')]),

            'name.required' => trans('error.required', ['attribute' => trans('student-information.name')]),
            'name.between' => trans('error.between', ['attribute' => trans('student-information.name'), 'min' => 2, 'max' => 32]),

            'email.required' => trans('error.required', ['attribute' => trans('student-information.email')]),
            'email.email' => trans('error.email', ['attribute' => trans('student-information.email')]),

            'free_acad.required' => trans('error.required', ['attribute' => trans('student-information.free_acad')]),
            'free_acad.digits_between' => trans('error.digits_between', ['attribute' => trans('student-information.free_acad'), 'min' => 0, 'max' => 127]),

            'free_tech.required' => trans('error.required', ['attribute' => trans('student-information.free_tech')]),
            'free_tech.digits_between' => trans('error.digits_between', ['attribute' => trans('student-information.free_tech'), 'min' => 0, 'max' => 127]),

        ];
    }

}