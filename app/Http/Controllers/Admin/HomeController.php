<?php namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Infoexam\Account\Account;
use App\Infoexam\Account\Authenticate;
use Illuminate\Http\Request;

class HomeController extends Controller {

    public function index()
    {
        return view('admin.index');
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