<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class TestScoresUploadScoresRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ssn' => 'required|exists:test_lists,ssn',
            'overwrite' => 'boolean',
            'scores' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'ssn.required' => trans('error.required', ['attribute' => trans('test-scores.testList')]),
            'ssn.exists' => trans('error.exists', ['attribute' => trans('test-scores.testList')]),
            'overwrite.boolean' => trans('error.boolean', ['attribute' => trans('test-scores.overwrite')]),
            'scores.required' => trans('error.required', ['attribute' => trans('test-scores.file')]),
        ];
    }
}