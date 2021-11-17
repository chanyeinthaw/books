<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Response::macro('xml', function ($content, $fileName = 'download.xml') {
            $headers = [
                'Content-type'        => 'text/xml',
                'Content-Disposition' => 'attachment; filename=' . $fileName,
            ];

            return \Response::make($content, 200, $headers);
        });
    }
}
