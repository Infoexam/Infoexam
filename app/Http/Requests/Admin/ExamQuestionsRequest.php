<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ExamQuestionsRequest extends Request {
    
    public function rules()
    {
        $rule = [
            'topic' => 'required|min:1',
            'topic_image' => 'image',
            'level' => 'required|digits_between:1,3',
            'multiple' => 'boolean',
            'answer' => 'required|array'
        ];

        $this->boolean_parsing(['multiple', 'open_practice']);

        for ($i = 0; $i < 4; ++$i)
        {
            $c = 0;

            foreach ($this->file('option_image.'.$i, []) as $image) {

                if (null === $image)
                {
                    continue;
                }

                $rule['option_image.'.$i.'.'.$c++] = 'image';
            }
        }

        if ('PATCH' !== Request::method())
        {
            $rule['exam_set_ssn'] = 'required';
        }

        return $rule;
    }

    public function messages()
    {
        return [
            'exam_set_ssn.required' => trans('error.required', ['attribute' => 'ssn']),

            'topic.required' => trans('error.required', ['attribute' => trans('exam-questions.topic')]),
            'topic.min' => trans('error.digits_between', ['name' => trans('exam-questions.topic'), 'min' => 1]),

            'topic_image.image' => trans('error.image', ['attribute' => trans('general.image')]),
            'option_image.0.image' => trans('error.image', ['attribute' => trans('general.image')]),
            'option_image.1.image' => trans('error.image', ['attribute' => trans('general.image')]),
            'option_image.2.image' => trans('error.image', ['attribute' => trans('general.image')]),
            'option_image.3.image' => trans('error.image', ['attribute' => trans('general.image')]),

            'level.required' => trans('error.required', ['attribute' => trans('exam-questions.level')]),
            'level.digits_between' => trans('error.digits_between', ['name' => trans('exam-questions.level'), 'min' => 1, 'max' => 3]),

            'multiple.boolean' => trans('error.boolean', ['attribute' => trans('exam-questions.multiple')]),

            'answer.required' => trans('error.required', ['attribute' => trans('exam-questions.option')]),
        ];
    }

}
