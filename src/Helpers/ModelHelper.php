<?php

namespace Kemboielvis\LaravelCrudGenerator\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

class ModelHelper
{
    public static function getFillables(Model $model): array
    {
        return $model->getFillable();
    }

    public static function getModelName(string $name): string
    {
        return class_basename($name);
    }

    public static function getModelNameLowerCase(string $model): string
    {
        return strtolower(Str::plural(self::getModelName($model)));
    }

    public static function getModelsInModelDirectory(): array
    {
        $models = [];
        // Get all the files in the Models directory
        $files = app_path('Models');
        // Check if the directory exists
        if (File::isDirectory($files)) {
            // Get all the files in the directory
            $files = File::allFiles($files);
            // Loop through the files
            foreach ($files as $file) {
                // Get the class name
                $className = self::getClassNameFromFile($file);
                // Check if the class exists
                if (class_exists($className)) {
                    // Add the class to the models array
                    $models[] = $className;
                }

            }
        }
        return $models;
    }

    protected static function getClassNameFromFile(SplFileInfo $file): string
    {
        // Get File content
        $fileName = $file->getFilenameWithoutExtension();
        // Get the namespace
        $namespace = self::getNamespaceFromFile($file);
        // Get the class name
        $className = $fileName;
        // Check if the file has a namespace
        if ($namespace) {
            $className = $namespace . '\\' . $fileName;
        }
        return $className;
    }

    private static function getNamespaceFromFile(SplFileInfo $file): string
    {
        // Get the content of the file
        $content = $file->getContents();
        // Get the namespace
        $namespace = '';
        // Get the namespace
        if (preg_match('/namespace (.*);/', $content, $matches)) {
            $namespace = $matches[1];
        }
        return $namespace;
    }

    public static function instantiateModelClass(string $model)
    {
        $model = "App\\Models\\".$model;
        // Check if the class exists and is a subclass of Model of Eloquent
        if (class_exists($model, autoload: true) && is_subclass_of($model, Model::class)) {
            return new $model();
        }
        return null;
    }

}
