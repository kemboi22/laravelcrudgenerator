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
            $this->info('Starting CRUD generation for: ' . $name);

            $this->generateCRUD($name);

            $this->info('CRUD generation completed for: ' . $name);
        } else {
            $models = ModelHelper::getModelsInModelDirectory();

            if ($this->confirm('Do you want to generate CRUD for all models?')) {
                $this->info('Found ' . count($models) . ' models to process.');

                foreach ($models as $index => $model) {
                    $this->info('[Processing] (' . ($index + 1) . '/' . count($models) . ') Generating CRUD for: ' . $model);

                    $this->generateCRUD($model);

                    $this->info('[Success] CRUD generated for: ' . $model);
                }

                $this->info('CRUD generation completed for all models.');
            } else {
                $this->warn('Operation aborted by the user.');
            }
        }
    }

    /**
     *  Generate CRUD files for given model
     */
    protected function generateCRUD(string $model)
    {
        ControllerProcessor::generateController($model);
        RequestProcessor::generateRequest($model);
        ResourceProcessor::generateResource($model);
    }
}
