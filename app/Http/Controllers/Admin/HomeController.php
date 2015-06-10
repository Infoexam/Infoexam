<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Infoexam\Account\Account;
use App\Infoexam\Account\Authenticate;
use Auth;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class HomeController extends Controller
{
    public function index()
    {
        $logs = Activity::with('user')->where('text', 'not like', '%"login"%')->latest()->limit(10)->get()
            ->transform(function($item)
            {
                $item->setAttribute('text', json_decode($item->text));

                $content = (array) $item->text->content;

                $item->text->{'content'} = implode(', ', array_map(function ($v, $k) { return sprintf("%s:%s", $k, $v); }, $content, array_keys($content)));

                return $item;
            });

        return view('admin.index', compact('logs'));
    }

    public function login(Authenticate $auth)
    {
        /*
         * 檢查使用者是否已登入並且是 admin 群組，如條件成立，則直接轉向首頁，否則顯示登入畫面
         */
        if (Account::isAdmin())
        {
            return redirect()->route('admin.index');
        }

        $title = trans('general.login');

        $recaptcha = $auth->needRecaptcha();

        return view('admin.login', compact('title', 'recaptcha'));
    }

    /**
     * Authenticating the user login
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function auth(Request $request)
    {
        $auth = new Authenticate($request->input('username'), $request->input('password'), 'admin');

        if ($auth->login(false))
        {
            return redirect()->route('admin.index');
        }

        return back()->withErrors(['loginFailed' => 'Invalid username or password.']);
    }

    /**
     * Logout the user
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        /*
         * 檢查使用者是否已登入，如是，則登出之
         */
        if (Auth::check())
        {
            Auth::logout();

            flash()->success(trans('general.logout.success'));
        }

        return redirect()->route('admin.login');
    }
}