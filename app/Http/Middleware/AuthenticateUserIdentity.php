<?php namespace App\Http\Middleware;

use App\Infoexam\Account\Account;
use App\Infoexam\Exam\ExamAuth;
use Closure;

class AuthenticateUserIdentity {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
         * 驗證使用者是否已登錄且符合該頁面訪問權限
         */
        $domain = $request->segment(1);

        if (in_array($domain, ['images', 'api']))
        {
            return $next($request);
        }
        else if ('admin' === $domain)
        {
            if ( ! Account::isAdmin())
            {
                return redirect()->route('admin.login');
            }
        }
        else
        {
            if ( ! (Account::isStudent() || Account::isInvigilator() || Account::isAdmin()))
            {
                return ('exam' === $domain) ? redirect()->route('exam.login') : redirect()->route('student.login');
            }

            if ('exam' === $domain)
            {
                $exam_check = new ExamAuth();

                if ( ! $exam_check->ensureHasExam())
                {
                    return redirect()->route('exam.login');
                }
            }
        }

        return $next($request);
    }

}
