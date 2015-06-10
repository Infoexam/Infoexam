<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\Exam\ExamConfig;

class ExamConfigsController extends Controller
{
    public function edit()
    {
        if (null === ($exam_configs = ExamConfig::first()))
        {
            return http_404('admin.index');
        }

        $room_list = ['214', '215', '216', '217', '109', '110'];

        $exam_configs->setAttribute('open_room', unserialize($exam_configs->open_room));

        return view('admin.exam-configs.edit', compact('room_list', 'exam_configs'));
    }

    public function update(Requests\Admin\ExamConfigsRequest $request)
    {
        if (null === ($exam_configs = ExamConfig::first()))
        {
            return http_404('admin.index');
        }

        $exam_configs->update($request->all());

        return redirect()->route('admin.exam-configs.edit');
    }
}