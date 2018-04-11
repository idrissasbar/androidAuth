<?php

namespace App\Providers\v1;

use App\Services\v1\ChildrensService;
use Illuminate\Support\ServiceProvider;

class ChildServiceProvider extends ServiceProvider
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
        $this->app->bind(ChildrensService::class,function($app){
            return new ChildrensService();
        });
    }
}
