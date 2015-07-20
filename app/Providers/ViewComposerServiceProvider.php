<?php

namespace App\Providers;

use Illuminate\Auth\Guard;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Auth\Guard $guard
     * @return void
     */
    public function boot(\Illuminate\Http\Request $request, Guard $guard)
    {
        $this->composePjax($request);

        $this->composeGuard($guard);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Inject pjax variable to all views.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function composePjax($request)
    {
        view()->composer('*', function($view) use ($request)
        {
            $view->with('pjax', $request->pjax());
        });
    }

    /**
     * Inject guard variable to all views.
     *
     * @param \Illuminate\Auth\Guard $guard
     * @return void
     */
    private function composeGuard($guard)
    {
        view()->composer('*', function($view) use ($guard)
        {
            $view->with('guard', $guard);
        });
    }
}