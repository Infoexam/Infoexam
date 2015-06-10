<?php namespace App\Infoexam\Account;

class UserSearch {

    /**
     * The account model.
     *
     * @var \Illuminate\Database\Eloquent\Model|null
     */
    protected $model;

    /**
     * Create a new Authenticate instance.
     *
     * @param \App\Infoexam\Account\Account  $model
     */
    public function __construct(Account $model)
    {
        $this->model = $model->with(['userData.department'])
            ->leftJoin('user_data', 'accounts.id', '=', 'user_data.account_id')
            ->leftJoin('accredited_data', 'accounts.id', '=', 'accredited_data.account_id');
    }

    /**
     * Create a new Authenticate instance.
     *
     * @param  array  $query
     * @param  integer  $perPage
     * @return \App\Infoexam\Account\Account
     */
    public function searchPaginated(array $query = [], $perPage = 15)
    {
        foreach ($query as $key => &$value)
        {
            if ( ! empty($value))
            {
                switch ($key)
                {
                    case 'username':
                        $this->model = $this->model->username($value);
                        break;
                    case 'name':
                        $this->model = $this->model->name($value);
                        break;
                    case 'passed':
                        $this->model = $this->model->passed(true);
                        break;
                    case 'non_passed':
                        $this->model = $this->model->passed(false);
                        break;
                    case 'non_student':
                        $this->model = $this->model->student(false);
                        break;
                    case 'department':
                        if (0 != $value)
                        {
                            $this->model = $this->model->department($value);
                        }
                        break;
                }
            }
        }

        return $this->model->orderBy('username', 'asc')->paginate($perPage);
    }

}