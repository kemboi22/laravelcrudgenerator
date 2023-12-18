<?php

namespace Kemboielvis\Laravelcrudgenerator\Helpers;

class Fillables
{
    /**
     * Get the fillables of a model
     *
     * @param string $modelName
     * @return array
     */
    public static function getFillables(string $modelName): array
    {
        $model = "App\\Models\\$modelName";
        return $model::getFillable();

    }

}