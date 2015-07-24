<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\Test\TestApply;
use App\Infoexam\Test\TestList;
use App\Infoexam\Test\TestListRepository;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function index(TestListRepository $testListRepository)
    {
        $title = trans('exam.panel.title');

        $exams = $testListRepository->getRecentlyExams();

        return view('exam.panel.index', compact('title', 'exams'));
    }

    public function show($ssn)
    {
        if (null === ($test = TestList::ssn($ssn)->first()))
        {
            return http_404('exam.panel.index');
        }

        return view('exam.panel.show', compact('test'));
    }

    public function listUsers($ssn)
    {
        if (null === ($test = TestList::with(['applies'])->ssn($ssn)->first()))
        {
            return http_404('exam.panel.index');
        }

        return view('exam.panel.listUsers', compact('test'));
    }

    public function updateUser(Request $request, $ssn, $user)
    {
        if ((null === ($apply = TestApply::ssn($user)->first())) || (null === $apply->test_result_id))
        {
            return http_404('exam.panel.index');
        }

        switch ($request->input('type'))
        {
            case 'allowRelogin':
                $apply->test_result->update(['allow_relogin' => ! ($apply->test_result->allow_relogin)]);
                break;
            case 'examTimeExtends':
                $apply->test_result->update(['exam_time_extends' => intval($request->input('exam_time_extends', 0))]);
                break;
        }

        return redirect()->route('exam.panel.listUsers', ['ssn' => $ssn]);
    }

    public function update(Request $request, $ssn)
    {
        if (null === ($test = TestList::ssn($ssn)->first()))
        {
            return http_404('exam.panel.index');
        }

        switch ($request->input('type'))
        {
            case 'test_started':
                $test->update(['test_started' => ! ($test->test_started)]);
                $this->updateCache($test);
                break;
            case 'extend_time':
                $test->update(['end_time' => ($test->end_time->addMinutes(intval($request->input('extend_time', 0))))]);
                $this->updateCache($test);
                break;
        }

        return redirect()->route('exam.panel.show', ['ssn' => $ssn]);
    }

    public function updateCache(TestList $test)
    {
        \Cache::put(('exam_' . $test->ssn), $test, $test->end_time->addMinutes(120));
    }
}