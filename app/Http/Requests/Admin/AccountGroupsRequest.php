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
        $this->boolean_parsing(['isStudent', 'isInvigilator', 'isAdmin', 'isNoLogin']);

        $account_groups_id = $this->segments();

        $this->merge(['permissions' => serialize([
            'isStudent' => $this->input('isStudent'),
            'isInvigilator' => $this->input('isInvigilator'),
            'isAdmin' => $this->input('isAdmin'),
            'isNoLogin' => $this->input('isNoLogin')
        ])]);

        return [
            'name' => 'required|unique:groups,name,' . end($account_groups_id),
            'isStudent' => 'boolean',
            'isInvigilator' => 'boolean',
            'isAdmin' => 'boolean',
            'isNoLogin' => 'boolean',
        ];
    }

}
