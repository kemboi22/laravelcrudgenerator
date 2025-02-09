<?php

namespace Kemboielvis\LaravelCrudGenerator\Processor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Kemboielvis\LaravelCrudGenerator\Helpers\ModelHelper;
use Kemboielvis\LaravelCrudGenerator\Helpers\StubHelper;

class ControllerProcessor
{
    /**
     * Generate a controller
     *
     * @param string $model
     * @return void
     */

    public static function generateController(string $model): void
    {
        $controller = StubHelper::getStub('Controller');
        // Get the content of the controller stub
        $controllerStubContent = $controller;
        // Replace placeholders
        $controllerContent = self::replacePlaceHolders($controllerStubContent, $model);
        //        print_r($controllerContent);
        // Save the controller
        self::saveController($model, $controllerContent);
    }
    /**
    * Get the fields of a model
     *
     * @param string $modelName
     * @return array
     */

    private static function getFields(string $modelName): array
    {
        $model = ModelHelper::instantiateModelClass($modelName);
        if (!$model) {
            return [];
        }
        return ModelHelper::getFillables($model);
    }

    /**
     * Format the fields to be used in the controller
     *
     * @param array $fields
     * @return string
     */
    private static function formatToRequestFields(array $fields): string
    {
        $formattedFields = [];
        foreach ($fields as $field) {
            $formattedFields[] = "'$field' => \$request->$field";
        }
        return implode(",\n", $formattedFields);
    }
    /**
     * Replace placeholders in the controller stub
     *
     * @param string $stubContent
     * @param string $modelName
     * @return string
     */

    protected static function replacePlaceHolders(string $stubContent, string $modelName): string
    {
        $fields = self::getFields($modelName);
        $lowerCaseModelName = Str::lower($modelName);
        $fields = self::formatToRequestFields($fields);
        $modelName = ModelHelper::getModelName($modelName);
        return str_replace(['{{ $modelName }}', '{{ $fields }}'], [$lowerCaseModelName, $fields], $stubContent);
    }

    /**
     * Save the controller
     *
     * @param string $modelName
     * @param string $controllerContent
     * @return bool|int
     */
    protected static function saveController(string $modelName, string $controllerContent): bool|int
    {
        // Check if controller exists
        $controller = app_path("Http/Controllers/{$modelName}Controller.php");
        if (file_exists($controller)) {
            // Replace content inside
            return file_put_contents($controller, $controllerContent);
        }
        // Save the controller
        return file_put_contents($controller, $controllerContent);
    }

}
