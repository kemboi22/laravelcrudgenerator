<?php

namespace Kemboielvis\Laravelcrudgenerator\Helpers;

class CheckIfRequestExists
{
    /**
     * Check if store request exists
     * @param string $modelName
     * @return bool
     */

    protected static function checkStoreRequest(string $modelName): bool
    {
        $storeRequestClass = "App\\Http\\Requests\\Store"."$modelName"."Request";
        if (!class_exists($storeRequestClass)) {
            return false;
        }
        return true;
    }

    /**
     * Check if update request exists
     * @param string $modelName
     * @return bool
     */

    protected static function checkUpdateRequest(string $modelName): bool
    {
        $updateRequestClass = "App\\Http\\Requests\\Update"."$modelName"."Request";
        if (!class_exists($updateRequestClass)) {
            return false;
        }
        return true;
    }
}