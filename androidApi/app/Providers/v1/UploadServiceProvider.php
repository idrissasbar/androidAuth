<?php

namespace App\Providers\v1;

use Illuminate\Support\ServiceProvider;


class UploadServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(UploadsServices::class,function($app){
            return new UploadsServices();
        });
    }
}