<?php

namespace Kemboielvis\LaravelCrudGenerator\Helpers;

use Illuminate\Console\Command;

class CommandHelper
{
    protected Command $command;

    public function __construct()
    {
        $this->command = new class extends Command {
            public function handle()
            {

            }

        };
    }

    public function info(string $message): void
    {
        $this->command->info($message);
    }

}
