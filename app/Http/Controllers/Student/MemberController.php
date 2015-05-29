<?php namespace App\Http\Controllers\Student;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class MemberController extends Controller {

    public function info(Request $request)
    {
        $info = $request->user();

        return view('student.member.info', compact('info'));
    }

    public function info_update(Requests\Student\MemberInfoRequest $request)
    {
        $request->user()->user_data->update(['email' => $request->input('email')]);

        flash()->success(trans('general.update.success'));

        return redirect()->route('student.member.info');
    }

}
