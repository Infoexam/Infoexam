<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\Account\Account;
use App\Infoexam\Account\Group;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AccountGroupsController extends Controller
{
    public function index()
    {
        $title = trans('account-groups.list');

        $groups = Group::paginate(10, ['id', 'name']);

        return view('admin.account-groups.index', compact('title', 'groups'));
    }
    
    public function create()
    {
        $title = trans('account-groups.create');

        return view('admin.account-groups.create', compact('title'));
    }

    public function store(Requests\Admin\AccountGroupsRequest $request)
    {
        Group::create($request->all());

        return redirect()->route('admin.account-groups.index');
    }

    public function edit($id)
    {
        if (null === ($group = Group::find($id)))
        {
            return http_404('admin.account-groups.index');
        }

        $title = trans('account-groups.edit');

        foreach (unserialize($group->permissions) as $key => &$value)
        {
            $group->setAttribute($key, $value);
        }

        return view('admin.account-groups.edit', compact('title', 'group'));
    }

    public function show($id)
    {
        if (null === ($group = Group::find($id)))
        {
            return http_404('admin.account-groups.index');
        }

        $accounts = new Account();

        $accounts = $accounts->leftJoin('user_data', 'accounts.id', '=', 'user_data.account_id')
            ->leftJoin('user_groups', 'accounts.id', '=', 'user_groups.account_id')
            ->where('user_groups.group_id', '=', $id)
            ->orderBy('accounts.username', 'asc')
            ->paginate(15, ['name', 'username']);

        return view('admin.account-groups.show', compact('group', 'accounts'));
    }

    public function update(Requests\Admin\AccountGroupsRequest $request, $id)
    {
        if (null === ($group = Group::find($id)))
        {
            http_404();
        }
        else
        {
            $group->update($request->all());
        }

        return redirect()->route('admin.account-groups.index');
    }

    public function destroy($id)
    {
        if (null === ($group = Group::find($id)))
        {
            http_404();
        }
        else
        {
            $group->delete();
        }

        return redirect()->route('admin.account-groups.index');
    }
}