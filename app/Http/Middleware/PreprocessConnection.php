<?php

namespace App\Http\Middleware;

use Closure;

class PreprocessConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ('images' !== $request->segment(1))
        {
            $response->headers->set('cache-control', 'no-cache, no-store, must-revalidate');
        }

        $tls = env('TLS_CONNECTION', false);

        /*
         * 判斷 additional headers 的值是否為 true ，如是則附加額外 headers
         */
        if (env('ADDITIONAL_HEADERS', false))
        {
            $access_control_allow_origin = (($tls) ? 'https://' : 'http://') . env('SERVER_DOMAIN_NAME');

            $response->headers->set('Access-Control-Allow-Origin', $access_control_allow_origin);
            $response->headers->set('X-Frame-Options', 'deny');
            $response->headers->set('X-XSS-Protection', '1; mode=block');
            $response->headers->set('X-Content-Type-Options', 'nosniff');

            if ($tls)
            {
                $response->headers->set('Strict-Transport-Security', 'max-age=2592000; includeSubDomains');
            }
        }

        /*
         * 判斷 tls connection 的直是否為 true ，如是則檢測是否為加密連線，如為非加密連線則重新導向為加密連線
         */
        if ($tls && ( ! $request->secure()))
        {
            return redirect()->secure($request->path());
        }

        return $response;
    }
}
