<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Infoexam\ExamSet\ExamSet;
use App\Infoexam\Paper\PaperList;
use App\Infoexam\Paper\PaperQuestion;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PaperQuestionsController extends Controller {
    
    public function create(Request $request)
    {
        try
        {
            $title = trans('paper-questions.create');

            PaperList::where('ssn', '=', $request->input('ssn'))->firstOrFail();

            $exam_sets = ExamSet::where('set_enable', '=', true)->get(['id', 'ssn', 'name']);

            foreach ($exam_sets as &$exam_set)
            {
                $exam_set->setAttribute('questions', $exam_set->questions);
            }

            return view('admin.paper-questions.create', compact('title', 'exam_sets'));
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.paper-lists.index');
        }
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