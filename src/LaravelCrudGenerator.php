<?php

namespace Kemboielvis\LaravelCrudGenerator;

use Illuminate\Console\Command;
use Kemboielvis\LaravelCrudGenerator\Helpers\ModelHelper;
use Kemboielvis\LaravelCrudGenerator\Processor\ControllerProcessor;
use Kemboielvis\LaravelCrudGenerator\Processor\RequestProcessor;
use Kemboielvis\LaravelCrudGenerator\Processor\ResourceProcessor;

class LaravelCrudGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:generate {name?}';

    /**
     * The console command description.
     */
    protected $description = 'Generate CRUD operations for a given model';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        if ($name) {
            $this->info('Generating CRUD for ' . $name . "\n");
            ControllerProcessor::generateController($name);
            RequestProcessor::generateRequest($name);
            ResourceProcessor::generateResource($name);
        } else {
            $models = ModelHelper::getModelsInModelDirectory();
            $this->info('Generating CRUD for all models');
            foreach ($models as $model) {
                $this->info('Generating CRUD for ' . $model);
                ControllerProcessor::generateController($model);
                RequestProcessor::generateRequest($model);
                ResourceProcessor::generateResource($model);
            }
        }
    }
}
