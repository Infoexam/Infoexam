<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\Test\TestList;
use App\Infoexam\Test\TestListRepository;
use App\Jobs\Student\ApplyTest;
use App\Jobs\Student\CancelTestApply;
use App\Jobs\Student\TransformTestApply;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestAppliesController extends Controller
{
    public function apply()
    {
        $title = trans('test-applies.apply_student');

        $test_lists = TestListRepository::getTestsStudentCanApply();

        $route = 'student.test-applies.store';

        $method = 'POST';

        return view('student.test-applies.apply', compact('title', 'test_lists', 'route', 'method'));
    }

    public function store(Request $request, $ssn)
    {
        if ( ! $this->dispatch(new ApplyTest($request->user(), $ssn)))
        {
            return redirect()->route('student.test-applies.apply');
        }

        return redirect()->route('student.test-applies.manage');
    }

    public function manage(Request $request)
    {
        $title = trans('test-applies.applies');

        $now = Carbon::now();

        $test_applies = $request->user()->applies()->with(['test_list'])->get()->filter(function($item) use ($now)
        {
            return $item->test_list->start_time > $now;
        })->sortBy('test_list.start_time');

        return view('student.test-applies.manage', compact('title', 'test_applies'));
    }

    public function destroy(Request $request, $ssn)
    {
        if ( ! $this->dispatch(new CancelTestApply($request->user(), $ssn)))
        {
            return back();
        }

        return redirect()->route('student.test-applies.manage');
    }

    public function manageUnite()
    {
        $title = trans('test-applies.manage_unite');

        $test_lists = TestListRepository::getUniteTestsStudentCanManage();

        $route = 'student.test-applies.update';

        $method = 'PATCH';

        return view('student.test-applies.apply', compact('title', 'test_lists', 'route', 'method'));
    }

    public function update(Request $request, $ssn)
    {
        if ( ! $this->dispatch(new TransformTestApply($request->user(), $ssn)))
        {
            return back();
        }

        return redirect()->route('student.test-applies.manage');
    }

    public function history(Request $request)
    {
        $title = trans('test-applies.history');

        $now = Carbon::now();

        $test_applies = $request->user()->applies()->with(['test_list'])->get()->filter(function($item) use ($now)
        {
            return $now > $item->test_list->end_time;
        });

        return view('student.test-applies.history', compact('title', 'test_applies'));
    }
}