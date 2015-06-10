<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\Website\IpRule;

class WebsiteIpsConfigsController extends Controller
{
    public function index()
    {
        $title = trans('website-configs.ips.list');

        $ips = IpRule::paginate(10, ['id', 'ip', 'student_page', 'exam_page', 'admin_page']);

        return view('admin.website-configs.ips.index', compact('title', 'ips'));
    }

    public function create()
    {
        $title = trans('website-configs.ips.create');

        return view('admin.website-configs.ips.create', compact('title'));
    }

    public function store(Requests\Admin\WebsiteIpsConfigsRequest $request)
    {
        IpRule::create($request->all());

        $this->updateCache();

        return redirect()->route('admin.website-configs.ips.index');
    }

    public function edit($id)
    {
        if (null === ($ip_rule = IpRule::find($id)))
        {
            return http_404('admin.website-configs.ips.index');
        }

        $title = trans('website-configs.ips.edit');

        return view('admin.website-configs.ips.edit', compact('title', 'ip_rule'));
    }

    public function update(Requests\Admin\WebsiteIpsConfigsRequest $request, $id)
    {
        if (null === ($ip = IpRule::find($id)))
        {
            http_404();
        }
        else
        {
            $ip->update($request->all());

            $this->updateCache();
        }

        return redirect()->route('admin.website-configs.ips.index');
    }

    public function destroy($id)
    {
        if (null === ($ip = IpRule::find($id)))
        {
            http_404();
        }
        else
        {
            $ip->delete();

            $this->updateCache();
        }

        return redirect()->route('admin.website-configs.ips.index');
    }

    public function updateCache()
    {
        \Cache::forever('ip_rules', IpRule::all(['ip', 'student_page', 'exam_page', 'admin_page']));
    }
}