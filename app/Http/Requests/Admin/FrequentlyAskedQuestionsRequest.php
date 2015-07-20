<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class FrequentlyAskedQuestionsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'question' => 'required|max:255',
            'answer' => 'required',
        ];

        foreach ($this->file('image', []) as $key => $image)
        {
            if (null !== $image)
            {
                $rules['image.'.$key] = 'image';
            }
        }

        return $rules;
    }

    /**
     * Set custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'question.required' => trans('error.required', ['attribute' => trans('faqs.question')]),
            'question.max' => trans('error.max', ['attribute' => trans('faqs.question'), 'max' => 255]),

            'answer.required' => trans('error.required', ['attribute' => trans('faqs.answer')]),

            'image' => trans('error.image', ['attribute' => trans('general.image')]),
        ];
    }
}