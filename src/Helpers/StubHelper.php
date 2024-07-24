<?php

namespace Kemboielvis\LaravelCrudGenerator\Helpers;

class StubHelper
{
    /**
     * Get the content of a stub file
     *
     * @param string $type
     * @return bool|string
     */
    public static function getStub(string $type): bool|string
    {
        return file_get_contents(__DIR__ . "/../../stubs/$type.stub");
    }

}
