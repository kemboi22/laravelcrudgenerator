<?php

namespace Kemboielvis\LaravelCrudGenerator\Processor;

use Illuminate\Console\Command;
use Kemboielvis\LaravelCrudGenerator\Helpers\CommandHelper;
use Kemboielvis\LaravelCrudGenerator\Helpers\MigrationHelper;
use Kemboielvis\LaravelCrudGenerator\Helpers\ModelHelper;
use Kemboielvis\LaravelCrudGenerator\Helpers\StubHelper;

class RequestProcessor
{

    /**
     * Generate a request
     *
     * @param string $modelName
     * @return void
     */
    public static function generateRequest(string $modelName): void
    {
        $stub = StubHelper::getStub("Request");
        $stubGetContent = $stub;
        $requestStoreContent = self::replacePlaceHolders($stubGetContent, $modelName, "Store");
        if (self::saveRequest($modelName, $requestStoreContent, "Store")) {
            (new CommandHelper())->info("Store Request created successfully");
        }
        $requestUpdateContent = self::replacePlaceHolders($stubGetContent, $modelName, "Update");
        if (self::saveRequest($modelName, $requestUpdateContent, "Update")) {
            (new CommandHelper())->info("Update Request created successfully");
        }

    }

    /**
     * Replace placeholders in the request stub
     *
     * @param string $modelName
     * @return array
     */

    public static function getAttributes(string $modelName): array
    {
        // Instantiate Model class
        $modelInstance = ModelHelper::instantiateModelClass($modelName);
        // Get the fillables
        $fillables = ModelHelper::getFillables($modelInstance);
        // Get Migration Content
        $migrationContent = MigrationHelper::getMigrationDetailsForModel($modelName);

        // Define rules
        $rules = [];

        // Loop through fillables
        foreach ($fillables as $fillable) {
            $rules[$fillable] = 'required';
        }
        return $rules;
    }


    public static function replacePlaceHolders(string $stubContent, string $modelName, string $type): array|string
    {
        /**
         * Get the attributes
         */
        $rules = var_export(self::getAttributes($modelName), true);
        /**
         * format array to be [] instead of array()
         */
        $rules = str_replace(array('array (', ')'), array('[', ']'), $rules);
        /**
         * Trim it to be correctly formated
         */
        $rules = rtrim($rules, " \t\n\r\0\x0B");

        /**
         * Replace the placeholders
         */
        return str_replace(
            ['{{ $fields }}', '{{ $requestType }}', '{{ $modelName }}'],
            [$rules, $type, $modelName],
            $stubContent
        );
    }

    public static function saveRequest(string $modelName, string $requestContent, string $type): bool|int
    {
        // Get request path
        $requestPath = app_path('Http/Requests');
        // Ensure the directory exists
        if (!is_dir($requestPath) && !mkdir($requestPath, 0755, true) && !is_dir($requestPath)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $requestPath));
        }
        // Create Model Name To Store Request
        $requestDir = $requestPath . '/' . $modelName;
        if (!is_dir($requestDir) && !mkdir($requestDir, 0755, true) && !is_dir($requestDir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $requestDir));
        }
        // Get request file name
        $requestFileName = $type.$modelName . 'Request.php';
        // Get request file
        $requestFile = $requestDir . '/' . $requestFileName;
        return file_put_contents($requestFile, $requestContent);
    }

}
