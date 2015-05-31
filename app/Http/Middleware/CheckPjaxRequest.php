<?php namespace App\Http\Middleware;

use Closure;

class CheckPjaxRequest {

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
         * 檢測是否為 pjax 請求，如是，則把 IS_PJAX 環境變數設置為 true
         */
        if ($request->pjax())
        {
            putenv('IS_PJAX=true');

            $response = $next($request);

            if ($response->isRedirect() && ! $request->isMethodSafe())
            {
                session()->flash('x_pjax_redirect', true);
            }
            else if ($request->isMethodSafe())
            {
                if (session('x_pjax_redirect', false))
                {
                    $response->headers->set('X-Pjax-Real-Url', $request->url());
                }
            }
            else
            {
                session()->forget('x_pjax_redirect');
            }

            return $response;
        }

        return $next($request);
    }

}