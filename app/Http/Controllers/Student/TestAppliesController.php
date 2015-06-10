<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\Test\TestList;
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

        $test_lists = TestList::where('test_enable', '=', true)
            ->where('allow_apply', '=', true)
            ->where('apply_type', 'like', '1\_%')
            ->where('start_time', '>=', Carbon::now()->addDays(1)->startOfDay())
            ->orderBy('start_time', 'asc')
            ->paginate(10);

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

        $test_applies = $request->user()
            ->applies
            ->filter(function($item) use ($now)
            {
                return $item->test_list->start_time > $now;
            })
            ->reverse();

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

        $test_lists = TestList::where('test_enable', '=', true)
            ->where('allow_apply', '=', true)
            ->where('apply_type', 'like', '2_%')
            ->where('start_time', '>=', Carbon::now()->addDays(1)->startOfDay())
            ->orderBy('start_time', 'asc')
            ->paginate(10);

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

        $test_applies = $request->user()->applies->filter(function($item) use ($now)
        {
            return $now > $item->test_list->end_time;
        });

        return view('student.test-applies.history', compact('title', 'test_applies'));
    }
}