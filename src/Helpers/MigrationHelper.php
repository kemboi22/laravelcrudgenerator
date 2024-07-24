<?php

namespace Kemboielvis\LaravelCrudGenerator\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MigrationHelper
{
    /**
     * Get the migration details for a model
     *
     * @param string $modelName
     * @return array
     */
    public static function getMigrationDetailsForModel(string $modelName): array
    {
        // Get all migration path
        $migrationsPath = database_path('migrations');
        // Get all migration files
        $migrationFiles = File::allFiles($migrationsPath);
        // Get the model migration file
        $modelMigration =[];
        // Loops through all migration files
        foreach ($migrationFiles as $migrationFile) {
            $fileName = $migrationFile->getFilename();
            // Check if the migration file contains the model name
            if (Str::contains($fileName, Str::snake(Str::plural($modelName)))) {
                // Get the migration content
                $migrationContent = file_get_contents($migrationFile->getRealPath());
                // Get the columns
                $columns = self::parseMigrationContent($migrationContent);
                // Add the columns to the model migration
                $modelMigration[$fileName] = $columns;
            }
        }
        return $modelMigration;
    }

    public static function parseMigrationContent(string $content): array
    {
        $columns = [];
        $lines = explode("\n", $content);
        foreach ($lines as $line) {
            if (preg_match('/\$(\w+)->(\w+)\((.*?)\)/', $line, $matches))
            {
                $columnName = $matches[1];
                $method = $matches[2];
                $attributes = $matches[3];
                // Check if its nullable
                $nullable = str_contains($line, '->nullable()') !== false;
                $required = !$nullable;
                // Add the column attributes on columns array
                $columns[$columnName] = [
                    "name" => $columnName,
                    "method" => $method,
                    "attributes" => $attributes,
                    "nullable" => $nullable,
                    "required" => $required
                ];

            }
        }
        return $columns;
    }

}
