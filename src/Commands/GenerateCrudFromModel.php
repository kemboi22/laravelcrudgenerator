<?php

namespace Kemboielvis\Laravelcrudgenerator\Commands;

use Illuminate\Console\Command;
use Kemboielvis\Laravelcrudgenerator\Helpers\Injector\CodeInjector;

class GenerateCrudFromModel extends Command
{
    protected $signature = 'crud:generate {model}';
    protected $description = 'Generate CRUD Operations from model';

    /**
     * @throws \ReflectionException
     */
    public function handle()
    {
        /**
         * Get model name
         */
        $modelName = $this->argument('model');
        /**
         * Get model class
         */
        $modelClass = "App\\Models\\$modelName";

        /**
         * Check if model exists
         */
        if (!class_exists($modelClass)) {
            $this->error('Model does not exist');
            return;
        }
        $this->info('Generating CRUD Operations from model ' . $modelName);

        $this->info("Fillable Fields: " . implode(', ', (new $modelClass)->getFillable()));

        $code = new CodeInjector($modelName);
        $code->injectController();
        $code->injectRequest();

        $this->info('CRUD Operations generated successfully');

    }

}