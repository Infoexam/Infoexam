<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\Exam\ExamTest;
use App\Infoexam\Paper\PaperList;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function testing($ssn)
    {
        if (null === ($test_data = \Cache::get('exam_' . $ssn)))
        {
            return redirect()->route('exam.login');
        }

        $examTest = new ExamTest($test_data);

        $questions = $examTest->getQuestions();

        $paging = 10;

        session()->put('examTest', $examTest);

        return view('exam.testing', compact('test_data', 'questions', 'paging'));
    }

    public function submit(Request $request)
    {
        if (null === ($examTest = session('examTest')))
        {
            return redirect()->route('exam.login');
        }

        $examTest->checkAnswer($request->except(['_token']));

        session()->forget('examTest');

        //logging(['level' => 'info', 'action' => 'finishPracticeExam', 'content' => ['score' => $score], 'remark' => null]);

        return redirect()->route('exam.result');
    }

    public function result()
    {
        return '222';
    }
}