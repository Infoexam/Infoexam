<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\Account\Account;
use App\Infoexam\Account\Authenticate;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Authenticate $auth)
    {
        /*
         * 檢查使用者是否已登入並且是 student 群組，如條件成立，則直接轉向首頁，否則顯示登入畫面
         */
        if (Account::isStudent())
        {
            return redirect()->route('student.index');
        }

        $title = trans('general.login');

        $recaptcha = $auth->needRecaptcha();

        return view('student.login', compact('title', 'recaptcha'));
    }

    public function auth(Request $request)
    {
        $auth = new Authenticate($request->input('username'), $request->input('password'), 'student');

        if ($auth->login())
        {
            return redirect()->route('student.index');
        }

        return redirect()->back()->withErrors(['loginFailed' => 'Invalid username or password.']);
    }

    public function logout()
    {
        if (Auth::check())
        {
            Auth::logout();

            flash()->success(trans('general.logout.success'));
        }

        return redirect()->route('student.login');
    }
}