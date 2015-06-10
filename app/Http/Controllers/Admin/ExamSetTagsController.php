<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\ExamSet\ExamSetTag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
                flash()->success(trans('general.create.failed'));
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
        try
        {
            $exam_sets = ExamSetTag::where('name', '=', $name)->firstOrFail()->exam_sets;

            return view('admin.exam-set-tags.show', compact('name', 'exam_sets'));
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.exam-set-tags.index');
        }
    }

    public function edit($name)
    {
        try
        {
            $title = trans('exam-set-tags.edit');

            $tag = ExamSetTag::where('name', '=', $name)->firstOrFail();

            return view('admin.exam-set-tags.edit', compact('title', 'tag'));
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.exam-set-tags.index');
        }
    }

    public function update(Request $request, $name)
    {
        try
        {
            $tag = ExamSetTag::where('name', '=', $name)->firstOrFail();

            $tag->update(['name' => $request->input('name', $name)]);
        }
        catch (ModelNotFoundException $e)
        {
            http_404();
        }
        catch (QueryException $e)
        {
            flash()->error(trans('exam-set-tags.exist'));
        }

        return redirect()->route('admin.exam-set-tags.index');
    }

    public function destroy($name)
    {
        try
        {
            ExamSetTag::where('name', '=', $name)->firstOrFail()->delete();
        }
        catch (ModelNotFoundException $e)
        {
            http_404();
        }

        return redirect()->route('admin.exam-set-tags.index');
    }
}