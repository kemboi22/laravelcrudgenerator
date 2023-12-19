<?php

namespace Kemboielvis\Laravelcrudgenerator\Helpers;

use Illuminate\Support\Facades\Artisan;

class GenerateClasses
{
    /**
     * Generate the controller class
     *
     * @param string $name
     * @return void
     */

    public static function generateControllerClass(string $modelName): void
    {
        Artisan::call('make:controller', [
            'name' => $modelName . 'Controller',
            '--resource' => true,
            '--model' => $modelName
        ]);
    }

    /**
     * Generate the Requests class
     *
     * @param string $name
     * @return void
     */

    public static function generateRequests(string $modelName): void
    {
        Artisan::call('make:request', [
            'name' => 'Store'.$modelName . 'Request'
        ]);
        Artisan::call('make:request', [
            'name' => 'Update'.$modelName . 'Request'
        ]);
    }

}