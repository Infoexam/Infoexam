<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Infoexam\Account\Account;
use App\Infoexam\Account\Group;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AccountGroupsController extends Controller {

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
        try
        {
            $title = trans('account-groups.edit');

            $group = Group::findOrFail($id);

            foreach (unserialize($group->permissions) as $key => &$value)
            {
                $group->setAttribute($key, $value);
            }

            return view('admin.account-groups.edit', compact('title', 'group'));
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.account-groups.index');
        }
    }

    public function show($id)
    {
        try
        {
            $group = Group::findOrFail($id);

            $accounts = new Account();

            $accounts = $accounts->leftJoin('user_data', 'accounts.id', '=', 'user_data.account_id')
                ->leftJoin('user_groups', 'accounts.id', '=', 'user_groups.account_id')
                ->where('user_groups.group_id', '=', $id)
                ->orderBy('accounts.username', 'asc')
                ->paginate(15);

            return view('admin.account-groups.show', compact('group', 'accounts'));
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.account-groups.index');
        }
    }

    public function update(Requests\Admin\AccountGroupsRequest $request, $id)
    {
        try
        {
            Group::findOrFail($id)->update($request->all());
        }
        catch (ModelNotFoundException $e)
        {
            http_404();
        }

        return redirect()->route('admin.account-groups.index');
    }

    public function destroy($id)
    {
        try
        {
            Group::findOrFail($id)->delete();
        }
        catch (ModelNotFoundException $e)
        {
            http_404();
        }

        return redirect()->route('admin.account-groups.index');
    }

}