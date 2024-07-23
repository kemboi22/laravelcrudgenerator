<?php

namespace Kemboielvis\LaravelCrudGenerator\Helpers;

class FileHelper
{
    public static function readFile(string $path): bool|string
    {
        return file_get_contents($path);
    }

    public static function writeFile(string $path, string $content): void
    {
        file_put_contents($path, $content);
    }

}
