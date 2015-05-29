<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class WebsiteConfigsRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->boolean_parsing(['student_page_maintain_mode', 'exam_page_maintain_mode']);

        return [
            'student_page_maintain_mode' => 'boolean',
            'exam_page_maintain_mode' => 'boolean',
            'g-recaptcha-response' => 'required|recaptcha',
        ];
    }

    public function messages()
    {
        return [
            'student_page_maintain_mode.boolean' => trans('error.boolean', ['attribute' => trans('website-configs.student_page_maintain_mode')]),
            'exam_page_maintain_mode.boolean' => trans('error.boolean', ['attribute' => trans('website-configs.exam_page_maintain_mode')]),
            'g-recaptcha-response.required' => 'Please ensure that you are a human!',
        ];
    }

}
