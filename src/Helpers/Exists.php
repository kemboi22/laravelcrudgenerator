<?php

namespace Kemboielvis\Laravelcrudgenerator\Helpers;

class Exists
{

    /**
     * Check if a Controller exists
     *
     * @param string $path
     * @return boolean
     */

    public static function checkIfControllerExits(string $modelName): bool
    {
        $controllerClass = "App\\Http\\Controllers\\$modelName"."Controller";
        if (!class_exists($controllerClass)) {
            return false;
        }
        return true;
    }
    /**
     * Check if a Store Requests exists
     *
     * @param string $path
     * @return boolean
     */

    public static function checkIfStoreRequestExists(string $modelName): bool
    {
        $storeRequestClass = "App\\Http\\Requests\\Store"."$modelName"."Request";
        if (!class_exists($storeRequestClass)) {
            return false;
        }
        return true;
    }
    /**
     * Check if a Update Requests exists
     *
     * @param string $path
     * @return boolean
     */

    public static function checkIfUpdateRequestsExists(string $modelName) : bool
    {
        $updateRequestClass = "App\\Http\\Requests\\Update"."$modelName"."Request";
        if (!class_exists($updateRequestClass)) {
            return false;
        }
        return true;
    }

}