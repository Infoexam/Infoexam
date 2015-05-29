<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Infoexam\Website\IpRule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class WebsiteIpsConfigsController extends Controller {

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

        return redirect()->route('admin.website-configs.ips.index');
    }

    public function edit($id)
    {
        try
        {
            $title = trans('website-configs.ips.edit');

            $ip_rule = IpRule::findOrFail($id);

            return view('admin.website-configs.ips.edit', compact('title', 'ip_rule'));
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.website-configs.ips.index');
        }
    }

    public function update(Requests\Admin\WebsiteIpsConfigsRequest $request, $id)
    {
        try
        {
            IpRule::findOrFail($id)->update($request->all());
        }
        catch (ModelNotFoundException $e)
        {
            http_404();
        }

        return redirect()->route('admin.website-configs.ips.index');
    }

    public function destroy($id)
    {
        try
        {
            IpRule::findOrFail($id)->delete();
        }
        catch (ModelNotFoundException $e)
        {
            http_404();
        }

        return redirect()->route('admin.website-configs.ips.index');
    }

}