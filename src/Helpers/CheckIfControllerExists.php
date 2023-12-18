<?php

namespace Kemboielvis\Laravelcrudgenerator\Helpers;

class CheckIfControllerExists
{
    /**
     * Check if controller exists
     * @param string $modelName
     * @return bool
     */

    protected static function check(string $modelName)
    {
        $controllerClass = "App\\Http\\Controllers\\$modelName"."Controller";
        if (!class_exists($controllerClass)) {
            return false;
        }
        return true;
    }

}