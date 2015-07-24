<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\Account\Authenticate;
use App\Infoexam\Exam\ExamAuth;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Authenticate $auth)
    {
        $title = trans('general.login');

        $recaptcha = $auth->needRecaptcha();

        session()->forget('examUser');

        Auth::logout();

        return view('exam.login', compact('title', 'recaptcha'));
    }

    public function auth(Request $request)
    {
        $auth = new ExamAuth();

        if ($auth->login($request->input('username'), $request->input('password')))
        {
            return ($auth->isInvigilator()) ? redirect()->route('exam.panel.index') : redirect()->route('exam.testing', ['ssn' => $auth->apply->test_list->ssn]);
        }

        return redirect()->route('exam.login');
    }

    public function logout()
    {
        if (Auth::check())
        {
            session()->forget('examUser');

            Auth::logout();

            flash()->success(trans('general.logout.success'));
        }

        return redirect()->route('exam.login');
    }
}