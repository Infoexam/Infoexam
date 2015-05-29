<?php namespace App\Http\Middleware;

use App;
use Carbon\Carbon;
use Closure;
use Jenssegers\Agent\Facades\Agent;

class PreprocessWebsiteInterface {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $accept_languages = ['zh-TW', 'en'];

        /*
         * 如 input 有 lan 變數及代表使用者手動切換介面語言，此時檢測是否為存在介面語言，如是則切換之，如否則使用預設語言
         */
        if ( ! is_null($lan = $request->input('lan')))
        {
            $lan = (in_array($lan, $accept_languages)) ? $lan : 'zh-TW';

            session()->put('lan', $lan);
        }

        $lan = session('lan');

        /*
         * 檢查 session 是否存在 lan 變數，如是則代表已設置過介面語言，則直接採用之，如否，則偵測瀏覽器接受的介面語言並設定之
         */
        if (is_null($lan))
        {
            $languages = Agent::languages();

            foreach ($languages as $language)
            {
                if ('zh-tw' === $language)
                {
                    $language = 'zh-TW';
                }

                if (in_array($language, $accept_languages))
                {
                    App::setLocale($language);

                    session()->put('lan', $language);

                    break;
                }
            }
        }
        else
        {
            App::setLocale($lan);

            Carbon::setLocale($lan);
        }

        return $next($request);
    }

}
