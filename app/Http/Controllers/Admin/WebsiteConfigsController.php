<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\Website\WebsiteConfig;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WebsiteConfigsController extends Controller
{
    public function edit()
    {
        try
        {
            $title = trans('website-configs.title');

            $website_configs = WebsiteConfig::firstOrFail();

            return view('admin.website-configs.edit', compact('title', 'website_configs'));
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.index');
        }
    }

    public function update(Requests\Admin\WebsiteConfigsRequest $request)
    {
        try
        {
            WebsiteConfig::firstOrFail()->update($request->all());

            \Cache::forever('website_maintain', WebsiteConfig::first());

            return redirect()->route('admin.website-configs.edit');
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.index');
        }
    }
}