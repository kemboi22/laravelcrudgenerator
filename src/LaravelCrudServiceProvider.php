<?php

namespace Kemboielvis\LaravelCrudGenerator;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class LaravelCrudServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//        $this->commands([
//            LaravelCrudGenerator::class
//        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }
        $this->commands([
            LaravelCrudGenerator::class
        ]);
    }

    public function provides()
    {
        return [
            LaravelCrudGenerator::class
        ];
    }

}
