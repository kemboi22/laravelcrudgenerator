<?php

namespace Kemboielvis\Laravelcrudgenerator\Helpers;

class ClassGetters
{
    /**
     * Get the Controller class
     *
     * @param string $modelName
     * @return string
     */

    public static function getControllerClass(string $modelName): string
    {
        return "App\\Http\\Controllers\\$modelName" . "Controller";
    }

    /**
     * Get the store Request class
     *
     * @param string $modelName
     * @return string
     */
    public static function getStoreRequestClass(string $modelName): string
    {
        return "App\\Http\\Requests\\Store" . "$modelName" . "Request";
    }

    /**
     * Get the update Request class
     *
     * @param string $modelName
     * @return string
     */
    public static function getUpdateRequestClass(string $modelName): string
    {
        return "App\\Http\\Requests\\Update" . "$modelName" . "Request";
    }

}