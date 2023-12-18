<?php

namespace Kemboielvis\Laravelcrudgenerator;

use Illuminate\Support\ServiceProvider;

class LaravelCrudServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            Commands\GenerateCrudFromModel::class,
        ]);
    }

}