<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\ExamSet\ExamSet;
use App\Infoexam\ExamSet\ExamSetTag;

class ExamSetsController extends Controller
{
    public function index()
    {
        $title = trans('exam-sets.title');

        $exam_sets = ExamSet::latest()->paginate(10, ['ssn', 'name', 'category', 'set_enable', 'open_practice']);

        return view('admin.exam-sets.index', compact('title', 'exam_sets'));
    }

    public function create()
    {
        $title = trans('exam-sets.create');

        $exam_set_tags = $this->getExamSetTags();

        return view('admin.exam-sets.create', compact('title', 'exam_set_tags'));
    }

    public function store(Requests\Admin\ExamSetsRequest $request)
    {
        if ( ! ExamSet::create($request->all())->exists)
        {
            return back()->withInput();
        }

        return redirect()->route('admin.exam-sets.index');
    }

    public function show($ssn)
    {
        if (null === ($exam_set = ExamSet::with(['questions'])->ssn($ssn)->first(['id', 'ssn', 'name'])))
        {
            return http_404('admin.exam-sets.index');
        }

        $title = trans('exam-questions.list');

        return view('admin.exam-sets.show', compact('title', 'exam_set'));
    }

    public function edit($ssn)
    {
        if (null === ($exam_set = ExamSet::ssn($ssn)->first()))
        {
            return http_404('admin.exam-sets.index');
        }

        $title = trans('exam-sets.edit');

        $exam_set_tags = $this->getExamSetTags();

        return view('admin.exam-sets.edit', compact('title', 'exam_set', 'exam_set_tags'));
    }

    public function update(Requests\Admin\ExamSetsRequest $request, $ssn)
    {
        if (null === ($exam_set = ExamSet::ssn($ssn)->first(['id'])))
        {
            http_404();
        }
        else
        {
            $exam_set->update($request->all());

            $exam_set->syncTags($request->input('exam_set_tag_list', []));
        }

        return redirect()->route('admin.exam-sets.index');
    }

    public function destroy($ssn)
    {
        if (null === ($exam_set = ExamSet::ssn($ssn)->first()))
        {
            http_404();
        }
        else
        {
            $exam_set->delete();
        }

        return redirect()->route('admin.exam-sets.index');
    }

    public function getExamSetTags()
    {
        return ExamSetTag::lists('name', 'id');
    }
}