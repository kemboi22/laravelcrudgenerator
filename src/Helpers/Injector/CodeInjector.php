<?php

namespace Kemboielvis\Laravelcrudgenerator\Helpers\Injector;

use Kemboielvis\Laravelcrudgenerator\Helpers\ClassGetters;
use Kemboielvis\Laravelcrudgenerator\Helpers\Exists;
use Kemboielvis\Laravelcrudgenerator\Helpers\GenerateClasses;
use Kemboielvis\Laravelcrudgenerator\Helpers\Injector\Controllers\ControllerCodeInjector;
use Kemboielvis\Laravelcrudgenerator\Helpers\Injector\Requests\RequestsCodeInjector;
use ReflectionClass;

class CodeInjector
{
    private string $modelName;

    public function __construct(string $modelName)
    {
        $this->modelName = $modelName;
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    public function injectController(): void
    {
        /**
         * Check if the controller exists
         * If it does not exist, generate it
         */
        $controllerExists = Exists::checkIfControllerExits($this->modelName);

        /**
         * If the controller exists, get the reflection class
         */
        if (!$controllerExists) {
            GenerateClasses::generateControllerClass($this->modelName);
        }

        /**
         * Get the reflection class
         */
        $reflection = new \ReflectionClass(ClassGetters::getControllerClass($this->modelName));


        /**
         * Replace the content of the index method
         */
        if ($reflection->getMethod('index')) {

            /**
             * Store the Generated Code
             */
            $generatedCode = ControllerCodeInjector::injectIndexCode($this->modelName);
            print_r($generatedCode);

            /**
             * Get the current content of the store method And Replace it with the generated code
             */
            $currentContent = $this->replaceMethodContents($reflection, $generatedCode, 'index');

        }

        /**
         * Get the store method
         */
        if ($reflection->getMethod('store')) {

            /**
             * Store the Generated Code
             */
            $generatedCode = ControllerCodeInjector::injectStoreCode($this->modelName);
            print_r($generatedCode);
            /**
             * Get the current content of the store method And Replace it with the generated code
             */
            $currentContent = $this->replaceMethodContents($reflection, $generatedCode, 'store');

        }

        /**
         * Replace the content of the show method
         */
        if ($reflection->getMethod('show')) {

            /**
             * Store the Generated Code
             */
            $generatedCode = ControllerCodeInjector::injectShowCode($this->modelName);

            /**
             * Get the current content of the store method And Replace it with the generated code
             */
            $currentContent = $this->replaceMethodContents($reflection, $generatedCode, 'show');

        }

        /**
         * Replace the content of the update method
         */
        if ($reflection->getMethod('update')) {

            /**
             * Store the Generated Code
             */
            $generatedCode = ControllerCodeInjector::injectUpdateCode($this->modelName);

            /**
             * Get the current content of the store method And Replace it with the generated code
             */
            $currentContent = $this->replaceMethodContents($reflection, $generatedCode, 'update');

        }

        /**
         * Replace the content of the destroy method
         */
        if ($reflection->getMethod('destroy')) {

            /**
             * Store the Generated Code
             */
            $generatedCode = ControllerCodeInjector::injectDestroyCode($this->modelName);

            /**
             * Get the current content of the store method And Replace it with the generated code
             */
            $currentContent = $this->replaceMethodContents($reflection, $generatedCode, 'destroy');

        }
    }

    /**
     * @throws \ReflectionException
     */
    public function injectRequest() : void
    {
        /**
         * Check if the request exists
         * If it does not exist, generate it
         */
        $storeRequestExists = Exists::checkIfStoreRequestExists($this->modelName);
        /**
         * Check if the request exists
         * If it does not exist, generate it
         */
        $updateRequestExists = Exists::checkIfUpdateRequestsExists($this->modelName);

        if (!$storeRequestExists && !$updateRequestExists) {
            GenerateClasses::generateRequests($this->modelName);
        }

        /**
         * Get the reflection class
         */

        $storeReflectionClass = new \ReflectionClass(ClassGetters::getStoreRequestClass($this->modelName));
        $updateReflectionClass = new \ReflectionClass(ClassGetters::getUpdateRequestClass($this->modelName));

        /**
         * Check if rules exists
         */
        if ($storeReflectionClass->getMethod('rules'))
        {
            /**
             * Get the Generated Code
             */
            $generatedCode = RequestsCodeInjector::injectStoreRequestCode($this->modelName);

            print_r($generatedCode);
            /**
             * Get the current content of the store method And Replace it with the generated code
             */
            $currentContent = $this->replaceMethodContents($storeReflectionClass, $generatedCode, 'rules');

        }

        /**
         * Check if rules exists
         */

        if ($updateReflectionClass->getMethod('rules'))
        {
            /**
             * Get the Generated Code
             */
            $generatedCode = RequestsCodeInjector::injectUpdateRequestCode($this->modelName);

            /**
             * Get the current content of the store method And Replace it with the generated code
             */
            $currentContent = $this->replaceMethodContents($updateReflectionClass, $generatedCode, 'rules');
        }


    }

    /**
     * @throws \ReflectionException
     */
    private function replaceMethodContents(ReflectionClass $reflection, $content, string $methodName): array|string
    {
        /**
         * Get the method
         */
        $method = $reflection->getMethod($methodName);

        /**
         * Get the start line of the method
         */

        $startLine = $method->getStartLine();

        /**
         * Get the end line of the method
         */

        $endLine = $method->getEndLine();

        /**
         * Get the method content
         */
        $currentContent = implode('', array_slice(file($reflection->getFileName()), $startLine - 1, $endLine - $startLine + 1));


        /**
         * Replace the content
         */
        return str_replace($currentContent, $content, $currentContent);


    }

}