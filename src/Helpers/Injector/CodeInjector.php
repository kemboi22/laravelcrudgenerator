<?php

namespace Kemboielvis\Laravelcrudgenerator\Helpers\Injector;

use Kemboielvis\Laravelcrudgenerator\Helpers\ClassGetters;
use Kemboielvis\Laravelcrudgenerator\Helpers\Exists;
use Kemboielvis\Laravelcrudgenerator\Helpers\GenerateClasses;

class CodeInjector
{
    private string $modelName;

    public function __construct(string $modelName)
    {
        $this->modelName = $modelName;
    }

    /**
     * @throws \ReflectionException
     */
    public function injectController()
    {
        $controllerExists = Exists::checkIfControllerExits($this->modelName);
        if (!$controllerExists) {
            GenerateClasses::generateControllerClass($this->modelName);
        }
        $reflection = new \ReflectionClass(ClassGetters::getControllerClass($this->modelName));
        $methods = $reflection->getMethods();
    }

}