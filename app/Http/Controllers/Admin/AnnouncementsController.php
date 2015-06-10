<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\Image;
use App\Infoexam\Website\Announcement;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AnnouncementsController extends Controller
{
    public function index()
    {
        $title = trans('announcements.list');

        $announcements = Announcement::orderBy('id', 'desc')->paginate(10, ['id', 'heading', 'created_at', 'updated_at']);

        return view('admin.announcements.index', compact('title', 'announcements'));
    }

    public function create()
    {
        $title = trans('announcements.create');

        return view('admin.announcements.create', compact('title'));
    }

    public function store(Requests\Admin\AnnouncementsRequest $request)
    {
        if ( ! Announcement::create($request->all())->exists)
        {
            return back()->withInput();
        }

        return redirect()->route('admin.announcements.index');
    }

    public function show($id)
    {
        if (null === ($announcement = Announcement::find($id)))
        {
            return http_404('admin.announcements.index');
        }

        $announcement->image_ssn = $this->explode_image_ssn($announcement->image_ssn);

        return view('admin.announcements.show', compact('announcement'));
    }

    public function edit($id)
    {
        if (null === ($announcement = Announcement::find($id)))
        {
            return http_404('admin.announcements.index');
        }

        $title = trans('announcements.edit');

        $announcement->image_ssn = $this->explode_image_ssn($announcement->image_ssn);

        return view('admin.announcements.edit', compact('title', 'announcement'));
    }

    public function update(Requests\Admin\AnnouncementsRequest $request, $id)
    {
        if (null === ($announcement = Announcement::find($id)))
        {
            return http_404('admin.announcements.index');
        }
        else if ( ! $announcement->update($request->all()))
        {
            return back()->withInput();
        }

        return redirect()->route('admin.announcements.show', ['announcements' => $id]);
    }

    public function destroy($id)
    {
        if (null === ($announcement = Announcement::find($id)))
        {
            http_404();
        }
        else
        {
            $announcement->delete();
        }

        return redirect()->route('admin.announcements.index');
    }

    public function destroy_images($id)
    {
        if (null === ($announcement = Announcement::find($id)))
        {
            http_404();
        }
        else if (null !== $announcement->image_ssn)
        {
            Image::whereIn('ssn', $this->explode_image_ssn($announcement->image_ssn))->delete();

            $announcement->update(['image_ssn' => null]);
        }

        return redirect()->route('admin.announcements.show', ['announcements' => $id]);
    }
}