<?php

namespace Kemboielvis\Laravelcrudgenerator\Commands;

use Illuminate\Console\Command;

class GenerateCrudFromModel extends Command
{
    protected $signature = 'crud:generate {model}';
    protected $description = 'Generate CRUD Operations from model';

    public function handle()
    {
        // Get model name
        $modelName = $this->argument('model');
        $modelClass = "App\\Models\\$modelName";

        // Check if model exists
        if (!class_exists($modelClass)) {
            $this->error('Model does not exist');
            return;
        }
        $this->info('Generating CRUD Operations from model');
    }

}