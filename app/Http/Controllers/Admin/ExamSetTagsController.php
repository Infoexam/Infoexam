<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\ExamSet\ExamSetTag;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ExamSetTagsController extends Controller
{
    public function index()
    {
        $title = trans('exam-set-tags.list');

        $tags = ExamSetTag::orderBy('name')->paginate(10, ['name']);

        return view('admin.exam-set-tags.index', compact('title', 'tags'));
    }

    public function create()
    {
        $title = trans('exam-set-tags.create');

        return view('admin.exam-set-tags.create', compact('title'));
    }

    public function store(Request $request)
    {
        try
        {
            if ( ! ((null !== ($name = $request->input('name'))) && (ExamSetTag::create(['name' => $name])->exists)))
            {
                flash()->error(trans('general.create.failed'));
            }
        }
        catch (QueryException $e)
        {
            flash()->error(trans('exam-set-tags.exist'));
        }

        return redirect()->route('admin.exam-set-tags.index');
    }

    public function show($name)
    {
        if (null === ($exam_set_tag = ExamSetTag::with(['exam_sets'])->where('name', '=', $name)->first()))
        {
            return http_404('admin.exam-set-tags.index');
        }

        return view('admin.exam-set-tags.show', compact('name', 'exam_set_tag'));
    }

    public function edit($name)
    {
        if (null === ($tag = ExamSetTag::where('name', '=', $name)->first(['name'])))
        {
            return http_404('admin.exam-set-tags.index');
        }

        $title = trans('exam-set-tags.edit');

        return view('admin.exam-set-tags.edit', compact('title', 'tag'));
    }

    public function update(Request $request, $name)
    {
        if (null === ($tag = ExamSetTag::where('name', '=', $name)->first()))
        {
            http_404();
        }
        else
        {
            try
            {
                $tag->update(['name' => $request->input('name', $name)]);
            }
            catch (QueryException $e)
            {
                flash()->error(trans('exam-set-tags.exist'));
            }
        }

        return redirect()->route('admin.exam-set-tags.index');
    }

    public function destroy($name)
    {
        if (null === ($tag = ExamSetTag::where('name', '=', $name)->first()))
        {
            http_404();
        }
        else
        {
            $tag->delete();
        }

        return redirect()->route('admin.exam-set-tags.index');
    }
}