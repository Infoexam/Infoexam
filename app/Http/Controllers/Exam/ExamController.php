<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\Exam\ExamTest;
use App\Infoexam\Paper\PaperList;
use App\Infoexam\Test\TestApply;
use Carbon\Carbon;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * @var \Illuminate\Auth\Guard
     */
    protected $guard;

    /**
     * @param \Illuminate\Auth\Guard $guard
     */
    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    public function testing($ssn)
    {
        if ((null === ($test_data = \Cache::get('exam_' . $ssn))) || (null === session('examUser')))
        {
            return redirect()->route('exam.login');
        }

        $examTest = new ExamTest($test_data);

        $questions = $examTest->getQuestions();

        $paging = 10;

        $examTime = $test_data->end_time->timestamp - Carbon::now()->timestamp + (session('exam_time_extends', 0) * 60);

        session()->put('examTest', $examTest);

        logging(['level' => 'info', 'action' => 'startExamTest', 'content' => ['ssn' => $ssn], 'remark' => null]);

        return view('exam.testing', compact('test_data', 'questions', 'paging', 'examTime'));
    }

    public function syncExamTime($ssn)
    {

    }

    public function submit(Request $request)
    {
        if (null === ($examTest = session('examTest')))
        {
            return redirect()->route('exam.login');
        }

        $examTest->checkAnswer($request->except(['_token']));

        session()->forget('examTest');

        $apply = TestApply::with(['test_result'])->where('account_id', '=', $this->guard->id())->first();

        $apply->test_result->update(['record' => json_encode($request->except(['_token'])), 'score' => $examTest->getScore()]);

        logging(['level' => 'info', 'action' => 'finishExamTest', 'content' => ['ssn' => $apply->test_list->ssb , 'score' => $examTest->getScore()], 'remark' => null]);

        return redirect()->route('exam.result');
    }

    public function result()
    {
        session()->forget('examUser');

        $this->guard->logout();

        flash()->success(trans('exam.finish'));

        return redirect()->route('exam.login');
    }
}