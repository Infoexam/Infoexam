<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Infoexam\Account\Account;
use App\Infoexam\Account\Department;
use App\Infoexam\Account\Group;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class StudentInformationController extends Controller {

    public function index()
    {
        $title = trans('student-information.search');

        $department_lists = array_merge(['0' => trans('student-information.department')], Department::lists('name', 'id'));

        return view('admin.student-information.index', compact('title', 'department_lists'));
    }

    public function search(Request $request)
    {
        $search = new Account();

        $search = $search->leftJoin('user_data', 'accounts.id', '=', 'user_data.account_id')
            ->leftJoin('accredited_data', 'accounts.id', '=', 'accredited_data.account_id');

        foreach ($request->all() as $key => &$value)
        {
            if ( ! strlen($value))
            {
                continue;
            }

            switch ($key)
            {
                case 'username':
                    $search = $search->username($value);
                    break;
                case 'name':
                    $search = $search->name($value);
                    break;
                case 'passed':
                    $search = $search->passed(true);
                    break;
                case 'non_passed':
                    $search = $search->passed(false);
                    break;
                case 'non_student':
                    $search = $search->student(false);
                    break;
                case 'department':
                    if (0 != $value)
                    {
                        $search = $search->department($value);
                    }
                    break;
            }
        }

        $accounts = $search->orderBy('accounts.username', 'asc')->paginate(15);

        return view('admin.student-information.search', compact('accounts'));
    }

    public function edit($user)
    {
        try
        {
            $account = Account::where('username', '=', $user)->firstOrFail();

            $groups = Group::lists('name', 'id');

            return view('admin.student-information.edit', compact('account', 'groups'));
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.student-information.index');
        }
    }

    public function update(Requests\Admin\StudentInformationRequest $request, $user)
    {
        try
        {
            $account = Account::where('username', '=', $user)->firstOrFail();

            if (strlen($request->input('new_password')))
            {
                $account->password = bcrypt($request->input('new_password'));

                $account->save();
            }

            $inputs = $request->all();

            $account->user_data->update($inputs);

            $account->accredited_data->update($inputs);

            $account->groups()->sync($request->input('group_list'));

            flash()->success(trans('general.update.success'));

            return redirect()->route('admin.student-information.edit', ['user' => $user]);
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.student-information.index');
        }
    }
    
}