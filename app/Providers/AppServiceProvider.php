<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     * @return void
     */
    public function boot(\Illuminate\Filesystem\Filesystem $filesystem)
    {
        foreach ($filesystem->files(app_path('Libraries/Macros')) as $file)
        {
            $filesystem->requireOnce($file);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}