<?php

namespace Kemboielvis\LaravelCrudGenerator\Processor;

use Kemboielvis\LaravelCrudGenerator\Helpers\ModelHelper;
use Kemboielvis\LaravelCrudGenerator\Helpers\StubHelper;

class ControllerProcessor
{

    public static function generateController(string $model): void
    {
        $controller = StubHelper::getStub('Controller');
        // Get the content of the controller stub
        $controllerStubContent = file_get_contents($controller);
        // Replace placeholders
        $controllerContent = self::replacePlaceHolders($controllerStubContent, $model);
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

    protected static function replacePlaceHolders(string $stubContent, string $modelName): string
    {
        $fields = self::getFields($modelName);
        $fields = self::formatToRequestFields($fields);
        $modelName = ModelHelper::getModelName($modelName);
        return str_replace(['{{modelName}}', '{{fields}}'], [$modelName, $fields], $stubContent);
    }

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
