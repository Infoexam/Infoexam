<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Infoexam\Exam\ExamConfig;

class TestListsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $open_room = implode(',', unserialize(ExamConfig::firstOrFail(['open_room'])->open_room));

        return [
            'start_time' => 'required|date',
            'test_time' => 'required|digits_between:1,360',
            'room' => 'required|in:'.($open_room),
            'apply_type' => ['required', 'regex:/^[\d]_[\d]$/'],
            'std_num_limit' => 'required|digits_between:1,255',
            'test_type' => ['required', 'regex:/^[\d]_[\d]$/'],
            'test_paper_type' => 'required_if:test_type,1_1,2_1|boolean',
            'test_paper_auto' => 'required_if:test_paper_type,1|array',
            'test_paper_auto_number' => 'required_if:test_paper_type,1|digits_between:1,100',
            'test_paper_auto_level' => 'required_if:test_paper_type,1|digits_between:0,3',
            'test_paper_specific' => 'required_if:test_paper_type,0|exists:paper_lists,ssn',
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
            'start_time.required' => trans('error.required', ['attribute' => trans('test-lists.start_time')]),
            'start_time.date' => trans('error.date', ['attribute' => trans('test-lists.start_time')]),

            'test_time.required' => trans('error.required', ['attribute' => trans('test-lists.test_time')]),
            'test_time.digits_between' => trans('error.digits_between', ['attribute' => trans('test-lists.test_time'), 'min' => 1, 'max' => 360]),

            'room.required' => trans('error.required', ['attribute' => trans('test-lists.room')]),
            'room.in' => 'The value of room field is invalid.',

            'apply_type.required' => trans('error.required', ['attribute' => trans('test-lists.apply_type')]),
            'apply_type.regex' => 'The value of apply type field is invalid.',

            'std_num_limit.required' => trans('error.required', ['attribute' => trans('test-lists.std_num_limit')]),
            'std_num_limit.digits_between' => trans('error.digits_between', ['attribute' => trans('test-lists.std_num_limit'), 'min' => 1, 'max' => 255]),

            'test_type.required' => trans('error.required', ['attribute' => trans('test-lists.test_type')]),
            'test_type.regex' => 'The value of test type field is invalid.',

            'test_paper_type.required_if' => trans('error.required', ['attribute' => trans('test-lists.test_paper')]),
            'test_paper_type.boolean' => trans('error.boolean', ['attribute' => trans('test-lists.test_paper')]),

            'test_paper_auto.required_if' => trans('error.required', ['attribute' => trans('test-lists.test_paper_auto')]),
            'test_paper_auto.array' => 'The value of test paper auto field is invalid.',

            'test_paper_auto_number.required_if' => trans('error.required', ['attribute' => trans('test-lists.test_paper_auto_number')]),
            'test_paper_auto_number.digits_between' => trans('error.digits_between', ['attribute' => trans('test-lists.test_paper_auto_number'), 'min' => 1, 'max' => 100]),

            'test_paper_auto_level.required_if' => trans('error.required', ['attribute' => trans('exam-questions.level')]),
            'test_paper_auto_level.digits_between' => trans('error.digits_between', ['attribute' => trans('exam-questions.level'), 'min' => 0, 'max' => 4]),

            'test_paper_specific.required_if' => trans('error.required', ['attribute' => trans('test-lists.test_paper_specific')]),
            'test_paper_specific.exists' => trans('error.exists', ['attribute' => trans('test-lists.test_paper_specific')]),
        ];
    }
}