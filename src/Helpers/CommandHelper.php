<?php

namespace Kemboielvis\LaravelCrudGenerator\Helpers;

use Illuminate\Console\Command;

class CommandHelper
{
    // ANSI escape codes for colors
    private const BLUE_BG = "\033[44m";
    private const RESET = "\033[0m";

    /**
     * Display a message with a blue background
     *
     * @param string $message
     * @return void
     */
    public function info(string $message): void
    {
        // Print the message with blue background and move to the next line
        echo self::BLUE_BG . "[INFO]" . self::RESET. $message . PHP_EOL. "\n";
    }
}
