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
            'heading' => 'required',
            'link' => 'url',
            'content' => 'required',
        ];

        $i = 0;

        foreach ($this->file('image', []) as $image) {

            if (is_null($image))
            {
                continue;
            }

            $rules['image.'.$i++] = 'image';
        }

        if ('PATCH' !== Request::method())
        {
            $rules['heading'] .= '|unique:announcements';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'heading.required' => trans('error.required', ['attribute' => trans('announcements.title')]),
            'heading.unique' => trans('error.unique', ['attribute' => trans('announcements.title')]),

            'link.url' => trans('error.url', ['attribute' => trans('announcements.link')]),

            'content.required' => trans('error.required', ['attribute' => trans('announcements.content')]),

            'image' => trans('error.image', ['attribute' => trans('general.image')]),
        ];
    }

}
