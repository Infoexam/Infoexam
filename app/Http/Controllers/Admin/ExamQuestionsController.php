<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\ExamSet\ExamOption;
use App\Infoexam\ExamSet\ExamQuestion;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ExamQuestionsController extends Controller
{
    public function create()
    {
        $title = trans('exam-questions.create');

        return view('admin.exam-questions.create', compact('title'));
    }

    public function store(Requests\Admin\ExamQuestionsRequest $request)
    {
        if ( ! ExamQuestion::create($request->all())->exists)
        {
            return back()->withInput($request->all());
        }

        return redirect()->route('admin.exam-sets.show', ['exam_sets' => $request->input('exam_set_ssn')]);
    }

    public function show($ssn)
    {
        try
        {
            $title = trans('exam-questions.show');

            $question = ExamQuestion::where('ssn', '=', $ssn)->firstOrFail();

            $question->answer = implode(',', unserialize($question->answer));

            $options = $question->options;

            $this->explode_collections_image_ssn($options);

            $exam_set = $question->exam_set;

            return view('admin.exam-questions.show', compact('title', 'question', 'options', 'exam_set'));
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
            $title = trans('exam-questions.edit');

            $question = ExamQuestion::where('ssn', '=', $ssn)->firstOrFail();

            $question->answer = unserialize($question->answer);

            $options = $question->options;

            $this->explode_collections_image_ssn($options);

            return view('admin.exam-questions.edit', compact('title', 'question', 'options'));
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.exam-sets.index');
        }
    }

    public function update(Requests\Admin\ExamQuestionsRequest $request, $ssn)
    {
        try
        {
            $question = ExamQuestion::where('ssn', '=', $ssn)->firstOrFail();

            if ( ! $question->update($request->all()) || ! ExamOption::updates($request->all()))
            {
                return back()->withInput($request->all());
            }

            return redirect()->route('admin.exam-questions.show', ['exam-questions' => $ssn]);
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.exam-sets.index');
        }
    }

    public function destroy($ssn)
    {
        try
        {
            $exam_set = ExamQuestion::where('ssn', '=', $ssn)->firstOrFail();

            $exam_set_ssn = $exam_set->exam_set->ssn;

            $exam_set->delete();

            return redirect()->route('admin.exam-sets.show', ['exam_sets' => $exam_set_ssn]);
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.exam-sets.index');
        }
    }
}