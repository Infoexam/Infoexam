<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class WebsiteIpsConfigsRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        while (str_contains($this->input('ip'), '**'))
        {
            $this->merge(['ip' => str_replace('**', '*', $this->input('ip'))]);
        }

        if (str_contains($this->input('ip'), '*'))
        {
            $this->merge(['ip_check' => str_replace('*', '1', $this->input('ip'))]);
        }
        else
        {
            $this->merge(['ip_check' => $this->input('ip')]);
        }

        $this->boolean_parsing(['student_page', 'exam_page', 'admin_page']);

        return [
            'ip' => 'required',
            'ip_check' => 'ip',
            'student_page' => 'boolean',
            'exam_page' => 'boolean',
            'admin_page' => 'boolean',
            'g-recaptcha-response' => 'required|recaptcha',
        ];
    }

    public function messages()
    {
        return [
            'ip.required' => trans('error.required', ['attribute' => trans('website-configs.ips.ip')]),
            'ip_check.ip' => trans('error.ip', ['attribute' => trans('website-configs.ips.ip')]),

            'student_page.boolean' => trans('error.boolean', ['attribute' => trans('website-configs.ips.student_page')]),
            'exam_page.boolean' => trans('error.boolean', ['attribute' => trans('website-configs.ips.exam_page')]),
            'admin_page.boolean' => trans('error.boolean', ['attribute' => trans('website-configs.ips.admin_page')]),

            'g-recaptcha-response.required' => 'Please ensure that you are a human!',
        ];
    }

}
