<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ExamConfigsRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->merge(['open_room' => serialize($this->input('open_room'))]);

        return [
            'open_room' => 'required',
            'acad_passed_score' => 'required|digits_between:0,100',
            'tech_passed_score' => 'required|digits_between:0,100',
            'latest_cancel_apply_day' => 'required|digits_between:0,127',
            'free_apply_grade' => 'required|digits_between:1,4',
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
            'open_room.required' => trans('error.required', ['attribute' => trans('exam-configs.open_room')]),

            'acad_passed_score.required' => trans('error.required', ['attribute' => trans('exam-configs.acad_passed_score')]),
            'acad_passed_score.digits_between' => trans('error.digits_between', ['attribute' => trans('exam-configs.acad_passed_score'), 'min' => 0, 'max' => 100]),

            'tech_passed_score.required' => trans('error.required', ['attribute' => trans('exam-configs.tech_passed_score')]),
            'tech_passed_score.digits_between' => trans('error.digits_between', ['attribute' => trans('exam-configs.tech_passed_score'), 'min' => 0, 'max' => 100]),

            'latest_cancel_apply_day.required' => trans('error.required', ['attribute' => trans('exam-configs.latest_cancel_apply_day')]),
            'latest_cancel_apply_day.digits_between' => trans('error.digits_between', ['attribute' => trans('exam-configs.latest_cancel_apply_day'), 'min' => 0, 'max' => 127]),

            'free_apply_grade.required' => trans('error.required', ['attribute' => trans('exam-configs.free_apply_grade')]),
            'free_apply_grade.digits_between' => trans('error.digits_between', ['attribute' => trans('exam-configs.free_apply_grade'), 'min' => 1, 'max' => 4]),

            'g-recaptcha-response.required' => 'Please ensure that you are a human!',
        ];
    }
}