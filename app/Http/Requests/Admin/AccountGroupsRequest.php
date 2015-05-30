<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class AccountGroupsRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->merge([
            'permissions' => serialize([
                'isStudent' => (bool) $this->input('isStudent'),
                'isInvigilator' => (bool) $this->input('isInvigilator'),
                'isAdmin' => (bool) $this->input('isAdmin'),
                'isNoLogin' => (bool) $this->input('isNoLogin')
            ])
        ]);

        return [
            'name' => 'required|unique:groups,name,' . last($this->segments())
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
            'name.required' => trans('error.required', ['attribute' => trans('account-groups.name')]),
            'name.unique' => trans('error.unique', ['attribute' => trans('account-groups.name')]),
        ];
    }

}