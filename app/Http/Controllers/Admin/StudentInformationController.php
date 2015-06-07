<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Infoexam\Account\Account;
use App\Infoexam\Account\Department;
use App\Infoexam\Account\Group;
use App\Infoexam\Account\UserSearch;
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
        $search = new UserSearch(new Account());

        $accounts = $search->searchPaginated($request->all(), 15);

        if (1 === $accounts->count())
        {
            return redirect()->route('admin.student-information.edit', ['user' => $accounts[0]->username]);
        }

        if ($request->has('page'))
        {
            return view('admin.student-information.search', compact('accounts'));
        }

        return response()->view('admin.student-information.search', compact('accounts'))->header('X-Pjax-Real-Url', $request->fullUrl());
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

            $inputs = $request->all();

            if (strlen($inputs['new_password']))
            {
                $account->password = bcrypt($inputs['new_password']);

                $account->save();
            }

            $account->userData->update($inputs);

            $account->accreditedData->update($inputs);

            $account->groups()->sync($request->input('group_list'));

            return redirect()->route('admin.student-information.edit', ['user' => $user]);
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.student-information.index');
        }
    }
    
}