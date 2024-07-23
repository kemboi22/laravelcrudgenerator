<?php

namespace Kemboielvis\LaravelCrudGenerator\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ModelHelper
{
    public static function getFillables(Model $model): array
    {
        return $model->getFillable();
    }

    public function getModelName(string $name): string
    {
        return class_basename($name);
    }

    public static function getModelNameLowerCase(string $model): string
    {
        return strtolower(Str::plural((new self)->getModelName($model)));
    }

}
