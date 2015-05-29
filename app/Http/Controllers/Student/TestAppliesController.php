<?php namespace App\Http\Controllers\Student;

use App\Commands\Student\ApplyTest;
use App\Commands\Student\CancelTestApply;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Infoexam\Admin\TestList;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestAppliesController extends Controller {

    public function index(Request $request)
    {
        $title = trans('test-applies.applies');

        $test_applies = $request->user()->applies;

        $now = Carbon::now();

        foreach ($test_applies as $key => $value)
        {
            if ($now > $value->test_list->start_time)
            {
                $test_applies->forget($key);
            }
        }

        return view('student.test-applies.index', compact('title', 'test_applies'));
    }

    public function apply()
    {
        $title = trans('test-applies.list');
        $test_lists = TestList::where('test_enable', '=', true)
            ->where('allow_apply', '=', true)
            ->where('apply_type', 'like', '1_%')
            ->where('start_time', '>=', Carbon::now()->addDays(1))
            ->orderBy('start_time', 'asc')
            ->paginate();

        return view('student.test-applies.apply', compact('title', 'test_lists'));
    }

    public function history(Request $request)
    {
        $title = trans('test-applies.history');

        $test_applies = $request->user()->applies;

        $now = Carbon::now();

        foreach ($test_applies as $key => $value)
        {
            if ($now <= $value->test_list->start_time)
            {
                $test_applies->forget($key);
            }
        }

        return view('student.test-applies.history', compact('title', 'test_applies'));
    }

    public function store(Request $request, $ssn)
    {
        if ( ! $this->dispatch(new ApplyTest($request, $ssn)))
        {
            return redirect()->route('student.test-applies.apply');
        }

        flash()->success(trans('test-applies.apply.success'));

        return redirect()->route('student.test-applies.index');
    }

    public function destroy(Request $request, $ssn)
    {
        if ( ! $this->dispatch(new CancelTestApply($request, $ssn)))
        {
            return redirect()->back();
        }

        flash()->success(trans('general.delete.success'));

        return redirect()->route('student.test-applies.index');
    }

}
