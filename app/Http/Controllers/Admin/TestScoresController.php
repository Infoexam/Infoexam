<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Infoexam\Test\TestApply;
use App\Infoexam\Test\TestList;
use App\Infoexam\Test\TestListRepository;
use Illuminate\Http\Request;

class TestScoresController extends Controller
{
    public function index()
    {
        $title = trans('test-scores.title');

        $lists = TestListRepository::getTestScoresListsAdminManage();

        $tests = TestListRepository::getTestScoresAdminManage();

        return view('admin.test-scores.index', compact('title', 'lists', 'tests'));
    }

    public function store(Requests\Admin\TestScoresUploadScoresRequest $request)
    {
        //
    }

    public function show($ssn)
    {
        if (null === ($test = TestList::ssn($ssn)->first()))
        {
            return http_404('admin.test-scores.index');
        }

        $title = trans('test-scores.show');

        $applies = $test->applies;

        return view('admin.test-scores.show', compact('title', 'ssn', 'applies'));
    }

    public function update(Request $request, $ssn)
    {
        if ((null === ($score = $request->input('score'))) || (null === ($apply = TestApply::ssn($ssn)->first())) || (null === $apply->test_result_id))
        {
            return response()->json(['success' => false]);
        }

        $apply->test_result->update(['score' => ($score < 0) ? null : $score]);

        return response()->json(['success' => true, 'score' => $apply->test_result->score]);
    }
}