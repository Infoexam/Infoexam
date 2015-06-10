<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\Website\WebsiteConfig;

class WebsiteConfigsController extends Controller
{
    public function edit()
    {
        if (null === ($website_configs = WebsiteConfig::first()))
        {
            return http_404('admin.index');
        }

        $title = trans('website-configs.title');

        return view('admin.website-configs.edit', compact('title', 'website_configs'));
    }

    public function update(Requests\Admin\WebsiteConfigsRequest $request)
    {
        if (null === ($website_configs = WebsiteConfig::first()))
        {
            return http_404('admin.index');
        }

        $website_configs->update($request->all());

        \Cache::forever('website_maintain', $website_configs);

        return redirect()->route('admin.website-configs.edit');
    }
}