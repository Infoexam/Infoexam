<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests;

class MemberController extends Controller
{
    public function info()
    {
        return view('student.member.info');
    }

    public function infoUpdate(Requests\Student\MemberInfoRequest $request)
    {
        $request->user()->userData->update(['email' => $request->input('email')]);

        return redirect()->route('student.member.info');
    }
}