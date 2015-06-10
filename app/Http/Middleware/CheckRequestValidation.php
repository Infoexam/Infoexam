<?php

namespace App\Http\Middleware;

use Closure;

class CheckRequestValidation
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
        switch ($request->method())
        {
            case 'POST':
            case 'PATCH':
                $request->offsetUnset('image_ssn');
                break;
            case 'DELETE':
                $validator = \Validator::make(
                    ['g-recaptcha-response' => $request->input('g-recaptcha-response')],
                    ['g-recaptcha-response' => 'required|recaptcha']
                );

                if ($validator->fails())
                {
                    flash()->error('Please ensure that you are a human!');

                    return back();
                }
                break;
        }

        return $next($request);
    }
}