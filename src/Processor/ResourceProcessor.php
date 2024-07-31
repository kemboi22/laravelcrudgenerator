<?php

namespace Kemboielvis\LaravelCrudGenerator\Processor;

use Illuminate\Console\Command;
use Kemboielvis\LaravelCrudGenerator\Helpers\CommandHelper;
use Kemboielvis\LaravelCrudGenerator\Helpers\ModelHelper;
use Kemboielvis\LaravelCrudGenerator\Helpers\StubHelper;

class ResourceProcessor
{
    /**
     * Generate a resource
     *
     * @param string $modelName
     * @return void
     */
    public static function generateResource(string $modelName): void
    {
        /**
         * Get the resource stub
         */
        $stubContent = StubHelper::getStub("Resource");
        /**
         * Replace placeholders in the resource stub
         */
        $resourceContent = self::replacePlaceHolders($modelName, $stubContent);
        /**
         * Save the resource
         */
        if (self::saveResource($modelName, $resourceContent)) {
            (new CommandHelper())->info("Resource created successfully");
        }
    }
    /**
     * Replace placeholders in the resource stub
     *
     * @param string $stubContent
     * @param string $modelName
     * @return string
     */

    private static function replacePlaceHolders(string $modelName, string $stubContent): string
    {
        /**
         * Get the attributes
         */
        $attributes = self::getAttributes($modelName);
        /**
         * Get the fields
         */
        $fields = var_export($attributes, true);
        /**
         * Replace the placeholders
         */
        return str_replace(
            ['{{ $modelName }}', '{{ $fields }}'],
            [$modelName, $fields],
            $stubContent
        );
    }

    /**
     * Get the attributes
     *
     * @param string $modelName
     * @return array
     */

    private static function getAttributes(string $modelName): array
    {
        /**
         * Instantiate Model class
         */
        $modelInstance = ModelHelper::instantiateModelClass($modelName);
        /**
         * Get the fillables
         */
        $fillables = ModelHelper::getFillables($modelInstance);
        /**
         * Loop through resource to create resource return array
         */
        $resource = [];
        foreach ($fillables as $fillable) {
            $resource[$fillable] = "\$this->$fillable";
        }
        /**
         * Return resource array
         */
        return $resource;
    }

    /**
     * Save the Resource
     *
     * @param string $modelName
     * @param string $content
     * @return bool
     */
    private static function saveResource(string $modelName, string $content): bool
    {
        /**
         * Get the resources path
         */
        $resourcePath = app_path("Http/Resources");
        /**
         * Ensure the directory exists
         * If not create it
         * If not able to create throw Runtime error
         */
        if (!file_exists($resourcePath) && !mkdir($resourcePath, 0755) && !is_dir($resourcePath)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $resourcePath));
        }
        /**
         * create ModelName directory
         */
        $resourcePath .= "/$modelName";
        /**
         * Ensure the directory exists
         * If not create it
         * If not able to create throw Runtime error
         */
        if (!file_exists($resourcePath) && !mkdir($resourcePath, 0755) && !is_dir($resourcePath)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $resourcePath));
        }
        /**
         * Create the file path
         */
        $filePath = $resourcePath . "/$modelName.php";
        /**
         * Save the content to the file
         */
        return file_put_contents($filePath, $content);
    }

}
