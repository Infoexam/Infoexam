<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\Account\Department;
use App\Infoexam\ExamSet\ExamSet;
use App\Infoexam\Paper\PaperList;
use App\Infoexam\Test\TestApply;
use App\Infoexam\Test\TestList;
use App\Infoexam\Test\TestListRepository;
use App\Jobs\Admin\ApplyTest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TestListsController extends Controller
{
    public function index(Request $request)
    {
        $title = trans('test-lists.list');

        $tested = (bool) $request->input('tested', false);

        $test_lists = TestList::Tested($tested)
            ->orderBy('start_time', $tested ? 'desc' : 'asc')
            ->paginate(10);

        $test_list_ssn = $test_lists->implode('attributes.ssn', ',');

        return view('admin.test-lists.index', compact('title', 'tested', 'test_lists', 'test_list_ssn'));
    }

    public function create(TestListRepository $testListRepository)
    {
        $title = trans('test-lists.create');

        $open_room = $testListRepository->getOpenRooms();

        $apply_type = $testListRepository->getApplyTypes();

        $test_type = $testListRepository->getTestTypes();

        $exam_sets = ExamSet::setEnable()->get(['ssn', 'name', 'category']);

        $paper_lists = PaperList::lists('name', 'ssn');

        return view('admin.test-lists.create', compact('title', 'open_room', 'apply_type', 'test_type', 'exam_sets', 'paper_lists'));
    }

    public function store(Requests\Admin\TestListsRequest $request)
    {
        $test_list = new TestList();

        if ( ! $test_list->create_test($request->all()))
        {
            return back()->withInput();
        }

        return redirect()->route('admin.test-lists.index');
    }

    public function show($ssn)
    {
        try
        {
            $title = trans('test-applies.applies');

            $applies = TestList::where('ssn', '=', $ssn)->firstOrFail()->applies()->paginate(15);

            return view('admin.test-lists.show', compact('title', 'applies', 'ssn'));
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.test-lists.index');
        }
    }

    public function update(Request $request, $ssn = null)
    {
        try
        {
            $type = $request->input('type');

            switch ($type)
            {
                case 'apply_status_all':
                    if (null !== ($list = $request->input('list')))
                    {
                        $list = explode(',', $list);

                        TestList::whereIn('ssn', $list)
                            ->where('start_time', '>', Carbon::now())
                            ->update(['allow_apply' => $request->input('update_all_status', 0)]);
                    }
                    break;

                case 'test_enable_all':
                    if (null !== ($list = $request->input('list')))
                    {
                        $list = explode(',', $list);

                        TestList::whereIn('ssn', $list)
                            ->where('start_time', '>', Carbon::now())
                            ->update(['test_enable' => $request->input('update_all_status', 0)]);
                    }
                    break;

                default:
                    $update = TestList::where('ssn', '=', $ssn)
                        ->where('start_time', '>', Carbon::now())
                        ->firstOrFail();

                    switch ($type)
                    {
                        case 'apply_status':
                            $update->update(['allow_apply' => ! ($update->allow_apply)]);
                            break;
                        case 'test_enable':
                            $update->update(['test_enable' => ! ($update->test_enable)]);
                            break;
                    }

                    flash()->success(trans('general.update.success'));
                    break;
            }
        }
        catch (ModelNotFoundException $e)
        {
            http_404();
        }

        return redirect()->route('admin.test-lists.index', ['page' => $request->input('page', 1)]);
    }

    public function destroy($ssn)
    {
        try
        {
            $test = TestList::where('ssn', '=', $ssn)->firstOrFail();

            if (Carbon::now() > $test->start_time || 0 < $test->std_apply_num || 0 < $test->applies->count())
            {
                flash()->error(trans('test-applies.error.admin.destroy_failed'));
            }
            else
            {
                TestApply::where('test_list_id', '=', $test->id)->delete();

                $test->delete();
            }
        }
        catch (ModelNotFoundException $e)
        {
            http_404();
        }

        return redirect()->route('admin.test-lists.index');
    }

    public function apply($ssn)
    {
        try
        {
            TestList::where('ssn', '=', $ssn)->firstOrFail();

            $department_lists = Department::orderBy('id', 'asc')->lists('name', 'id');

            return view('admin.test-lists.apply', compact('ssn', 'department_lists'));
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.test-lists.index');
        }
    }

    public function apply_store(Request $request, $ssn)
    {
        if ($this->dispatch(new ApplyTest($request, $ssn)))
        {
            flash()->success(trans('test-applies.apply.success'));
        }

        return redirect()->route('admin.test-lists.show', ['ssn' => $ssn]);
    }

    public function destroy_apply($test_ssn, $apply_ssn)
    {
        try
        {
            $apply = TestApply::where('ssn', '=', $apply_ssn)->firstOrFail();

            if (Carbon::now() < $apply->test_list->start_time && $apply->test_list->test_enable)
            {
                $apply->delete();

                flash()->success(trans('general.delete.success'));
            }
            else
            {
                flash()->error(trans('test-applies.error.invalid_apply'));
            }
        }
        catch (ModelNotFoundException $e)
        {
            http_404();
        }

        return redirect()->route('admin.test-lists.show', ['ssn' => $test_ssn]);
    }

    public function downloadPc2List($ssn)
    {
        if (null === ($test = TestList::with(['applies', 'applies.account'])->ssn($ssn)->first()))
        {
            return http_404('admin.test-lists.index');
        }

        $fp = fopen(($filename = storage_path('temp/' . $ssn)), "w+");

        fwrite($fp, "site\taccount\tpassword\tdisplayname\tpermdisplay\r\n");

        $i = 1;

        foreach ($test->applies as $apply)
        {
            $password = str_random(6);

            fwrite($fp, "1\tteam{$i}\t{$password}\t{$apply->account->username}\ttrue\r\n");

            ++$i;
        }

        return response()->download($filename, $ssn . '.txt');
    }
}