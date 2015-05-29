<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Infoexam\ExamSet\ExamSet;
use App\Infoexam\ExamSet\ExamSetTag;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ExamSetsController extends Controller {

    public function index()
    {
        $title = trans('exam-sets.title');

        $exam_sets = ExamSet::latest()->paginate(10, ['ssn', 'name', 'category', 'set_enable', 'open_practice']);

        return view('admin.exam-sets.index', compact('title', 'exam_sets'));
    }

    public function create()
    {
        $title = trans('exam-sets.create');

        $exam_set_tags = ExamSetTag::lists('name', 'id');

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
        try
        {
            $title = trans('exam-questions.list');

            $exam_set = ExamSet::where('ssn', '=', $ssn)->firstOrFail(['id', 'ssn', 'name']);

            $questions = $exam_set->questions;

            return view('admin.exam-sets.show', compact('title', 'exam_set', 'questions'));
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.exam-sets.index');
        }
    }

    public function edit($ssn)
    {
        try
        {
            $title = trans('exam-sets.edit');

            $exam_set = ExamSet::where('ssn', '=', $ssn)->firstOrFail();

            $exam_set_tags = ExamSetTag::lists('name', 'id');

            return view('admin.exam-sets.edit', compact('title', 'exam_set', 'exam_set_tags'));
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.exam-sets.index');
        }
    }

    public function update(Requests\Admin\ExamSetsRequest $request, $ssn)
    {
        try
        {
            $exam_set = ExamSet::where('ssn', '=', $ssn)->firstOrFail(['id']);

            $exam_set->update($request->all());

            $exam_set->syncTags($request->input('exam_set_tag_list', []));
        }
        catch (ModelNotFoundException $e)
        {
            http_404();
        }

        return redirect()->route('admin.exam-sets.index');
    }

    public function destroy($ssn)
    {
        try
        {
            ExamSet::where('ssn', '=', $ssn)->firstOrFail()->delete();

            return redirect()->route('admin.exam-sets.index');
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.exam-sets.index');
        }
    }

}