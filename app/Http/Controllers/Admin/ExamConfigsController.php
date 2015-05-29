<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Infoexam\Exam\ExamConfig;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ExamConfigsController extends Controller {

    public function edit()
    {
        try
        {
            $room_list = ['214', '215', '216', '217', '109', '110'];

            $exam_configs = ExamConfig::firstOrFail();

            $exam_configs->open_room = unserialize($exam_configs->open_room);

            return view('admin.exam-configs.edit', compact('room_list', 'exam_configs'));
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.index');
        }
    }

    public function update(Requests\Admin\ExamConfigsRequest $request)
    {
        try
        {
            ExamConfig::firstOrFail()->update($request->all());

            return redirect()->route('admin.exam-configs.edit');
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('admin.index');
        }
    }

}