<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\ExamSet\ExamSet;
use App\Infoexam\Paper\PaperList;
use App\Infoexam\Paper\PaperQuestion;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PaperQuestionsController extends Controller
{
    public function create(Request $request)
    {
        if (null !== PaperList::where('ssn', '=', $request->input('ssn'))->first(['id']))
        {
            $title = trans('paper-questions.create');

            $exam_sets = ExamSet::with('questions')->where('set_enable', '=', true)->get(['id', 'ssn', 'name']);

            return view('admin.paper-questions.create', compact('title', 'exam_sets'));
        }

        return http_404('admin.paper-lists.index');
    }

    public function store(Request $request)
    {
        if ( ! PaperQuestion::create($request->all()))
        {
            return back()->withInput();
        }

        return redirect()->route('admin.paper-lists.show', ['paper-lists' => $request->input('paper_ssn')]);
    }
    
    public function destroy($ssn)
    {
        try
        {
            $question = PaperQuestion::where('ssn', '=', $ssn)->firstOrFail();

            $paper = $question->paper_list;

            $question->delete();

            return redirect()->route('admin.paper-lists.show', ['paper-lists' => $paper->ssn]);
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.paper-lists.index');
        }
    }
}