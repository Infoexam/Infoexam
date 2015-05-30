<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Infoexam\Website\Announcement;
use App\Infoexam\Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AnnouncementsController extends Controller {

    public function index()
    {
        $title = trans('announcements.list');

        $announcements = Announcement::orderBy('id', 'desc')->paginate(10);

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
        try
        {
            $announcement = Announcement::findOrFail($id);

            $announcement->image_ssn = $this->explode_image_ssn($announcement->image_ssn);

            return view('admin.announcements.show', compact('announcement'));
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.announcements.index');
        }
    }

    public function edit($id)
    {
        try
        {
            $title = trans('announcements.edit');

            $announcement = Announcement::findOrFail($id);

            $announcement->image_ssn = $this->explode_image_ssn($announcement->image_ssn);

            return view('admin.announcements.edit', compact('title', 'announcement'));
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.announcements.index');
        }
    }

    public function update(Requests\Admin\AnnouncementsRequest $request, $id)
    {
        try
        {
            if ( ! Announcement::findOrFail($id)->update($request->all()))
            {
                return back()->withInput();
            }

            return redirect()->route('admin.announcements.show', ['announcements' => $id]);
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.announcements.index');
        }
    }

    public function destroy($id)
    {
        try
        {
            Announcement::findOrFail($id)->update(['image_ssn' => null])->delete();
        }
        catch (ModelNotFoundException $e)
        {
            http_404();
        }

        return redirect()->route('admin.announcements.index');
    }

    public function destroy_images($id)
    {
        try
        {
            $announcement = Announcement::findOrFail($id);

            if (null !== $announcement->image_ssn)
            {
                Image::whereIn('ssn', $this->explode_image_ssn($announcement->image_ssn))->delete();

                $announcement->update(['image_ssn' => null]);
            }
        }
        catch (ModelNotFoundException $e)
        {
            http_404();
        }

        return redirect()->route('admin.announcements.show', ['announcements' => $id]);
    }

}