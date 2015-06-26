<?php

namespace App\Http\Middleware;

use App\Infoexam\Account\Account;
use App\Infoexam\Exam\ExamAuth;
use Closure;

class AuthenticateUserIdentity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $domain
     * @return mixed
     */
    public function handle($request, Closure $next, $domain = null)
    {
        if (null === $domain)
        {
            return redirect()->route('student.index');
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