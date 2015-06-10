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
        if (null === (PaperList::ssn($request->input('ssn'))->exists()))
        {
            return http_404('admin.paper-lists.index');
        }

        $title = trans('paper-questions.create');

        $exam_sets = ExamSet::with('questions')->setEnable(true)->get(['id', 'ssn', 'name']);

        return view('admin.paper-questions.create', compact('title', 'exam_sets'));
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
        if (null === ($question = PaperQuestion::with(['paper_list'])->ssn($ssn)->first(['id', 'paper_list_id'])))
        {
            return http_404('admin.paper-lists.index');
        }

        $ssn = $question->paper_list->ssn;

        $question->delete();

        return redirect()->route('admin.paper-lists.show', ['paper-lists' => $ssn]);
    }
}