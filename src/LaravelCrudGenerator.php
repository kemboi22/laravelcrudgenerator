<?php

namespace Kemboielvis\LaravelCrudGenerator;

use Illuminate\Console\Command;

class LaravelCrudGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:generate {name}';
    /**
     * The console command description.
     *
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

        $this->info('Generating CRUD for ' . $name);
    }

}
