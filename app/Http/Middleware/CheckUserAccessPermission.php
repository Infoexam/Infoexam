<?php namespace App\Http\Middleware;

use App\Infoexam\Website\WebsiteConfig;
use App\Infoexam\Website\IpRule;
use Auth;
use Cache;
use Carbon\Carbon;
use Closure;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class CheckUserAccessPermission {

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
         * 取得使用者所訪問頁面的群組
         */
        switch ($request->segment(1))
        {
            case 'exam':
                $domain = 'exam';
                break;
            case 'admin':
                $domain = 'admin';
                break;
            case 'images':
                $domain = 'images';
                break;
            case 'api':
                $domain = 'api';
                break;
            default :
                $domain = 'student';
                break;
        }

        /*
         * 檢查使用者所訪問頁面是否處於維護模式
         */
        $website_maintain = Cache::rememberForever('website_maintain', function()
        {
            return WebsiteConfig::first();
        });

        if (null !== $website_maintain)
        {
            switch ($domain)
            {
                case 'student':
                    if ($website_maintain->student_page_maintain_mode)
                    {
                        throw new ServiceUnavailableHttpException;
                    }
                    break;
                case 'exam':
                    if ($website_maintain->exam_page_maintain_mode)
                    {
                        throw new ServiceUnavailableHttpException;
                    }
                    break;
            }
        }

        if ( ! in_array($domain, ['images', 'api']))
        {
            /*
             * 首先先進行 IP 過慮，取得使用者 IP 後將其與資料庫中之所有規則進行比對
             */
            $allow = ('student' === $domain) ? true : false;

            $ip = explode('.', $request->ip());

            $ip_rules = Cache::rememberForever('ip_rules', function()
            {
                return IpRule::all(['ip', 'student_page', 'exam_page', 'admin_page']);
            });

            foreach ($ip_rules as $rule)
            {
                $rule_ip = explode('.', $rule->ip);

                /*
                 * 檢查使用者 IP 是否 match 規則 IP
                 */
                for ($i = 0; $i < 4; $i++)
                {
                    if ('*' === $rule_ip[$i])
                    {
                        continue;
                    }

                    if ($ip[$i] !== $rule_ip[$i])
                    {
                        break;
                    }
                }

                /*
                 * 當 $i 值為 4 時，代表符合規則 IP，將進行權限判斷
                 *
                 * 學生頁面採黑名單模式，考試頁面及管理頁面採白名單模式，非貪婪式檢測
                 */
                if (4 === $i)
                {
                    switch ($domain)
                    {
                        case 'student':
                            if ( ! $rule->student_page)
                            {
                                $allow = false;

                                break 2;
                            }
                            break;
                        case 'exam':
                            if ($rule->exam_page)
                            {
                                $allow = true;

                                break 2;
                            }
                            break;
                        case 'admin':
                            if ($rule->admin_page)
                            {
                                $allow = true;

                                break 2;
                            }
                            break;
                    }
                }
            }

            if ( ! $allow)
            {
                throw new AccessDeniedHttpException;
            }
        }

        /*
         * 檢查使用者所屬群組是否含有禁止登入之群組
         */
        if (null !== ($auth = Auth::user()))
        {
            foreach ($auth->groups as $group)
            {
                if ($group->permissions['isNoLogin'])
                {
                    Auth::logout();

                    flash()->error('This account is not allow to login.');

                    if ('admin' === $domain)
                    {
                        return redirect()->route('admin.login');
                    }
                    else if ('exam' === $domain)
                    {
                        return redirect()->route('exam.login');
                    }

                    return redirect()->route('student.login');
                }
            }
        }

        return $next($request);
    }

}
