<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ExamSetsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setBool(['set_enable', 'open_practice']);

        return [
            'name' => 'required|between:3,32',
            'category' => 'required|in:A,S',
            'set_enable' => 'boolean',
            'open_practice' => 'boolean',
            'exam_set_tag_list' => 'exists:exam_set_tags,id',
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
            'name.required' => trans('error.required', ['attribute' => trans('exam-sets.name')]),
            'name.between' => trans('error.between', ['name' => trans('exam-sets.name'), 'min' => 3, 'max' => 32]),

            'category.required' => trans('error.boolean', ['attribute' => trans('exam-sets.category')]),
            'category.in' => 'The value of category field should be "Application" or "Software".',

            'set_enable.boolean' => trans('error.boolean', ['attribute' => trans('exam-sets.set_enable')]),

            'open_practice.boolean' => trans('error.boolean', ['attribute' => trans('exam-sets.open_practice')]),

            'exam_set_tag_list.exists' => trans('error.exists', ['attribute' => 'Tags']),
        ];
    }
}