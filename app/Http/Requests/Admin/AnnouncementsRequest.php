<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class AnnouncementsRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'heading' => 'required|max:255|unique:announcements,heading',
            'link' => 'url|max:255',
            'content' => 'required',
        ];

        if ($this->isMethod('PATCH'))
        {
            $rules['heading'] .= ',' . last($this->segments());
        }

        foreach ($this->file('image', []) as $key => &$image)
        {
            if (null !== $image)
            {
                $rules['image.'.$key] = 'image';
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'heading.required' => trans('error.required', ['attribute' => trans('announcements.title')]),
            'heading.max' => trans('error.max', ['attribute' => trans('announcements.title'), 'max' => 255]),
            'heading.unique' => trans('error.unique', ['attribute' => trans('announcements.title')]),

            'link.url' => trans('error.url', ['attribute' => trans('announcements.link')]),
            'link.max' => trans('error.max', ['attribute' => trans('announcements.link'), 'max' => 255]),

            'content.required' => trans('error.required', ['attribute' => trans('announcements.content')]),

            'image' => trans('error.image', ['attribute' => trans('general.image')]),
        ];
    }

}