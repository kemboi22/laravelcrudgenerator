<?php

namespace Kemboielvis\Laravelcrudgenerator\Helpers\Injector\Requests;

use Kemboielvis\Laravelcrudgenerator\Helpers\Fillables;

class RequestsCodeInjector
{

    /**
     * Inject the Store request code
     *
     * @param string $modelName
     * @return string
     */
    protected static function injectStoreRequestCode(string $modelName)
    {
        /**
         * Get the fillables of the model
         */
        $fillables = Fillables::getFillables($modelName);

        /**
         * Store Request Code
         */
        $storeRequestCode = "";

        /**
         * Generate the store request code
         */
        foreach ($fillables as $fillable) {
            $storeRequestCode .= "'{$fillable}' => 'required',";
        }

        /**
         * return the generated code
         */
        return <<<EOT
            public function rules() : array
            {
                return [
                    {$storeRequestCode}
                ];
            }
        EOT;


    }

    /**
     * Inject the Update request code
     *
     * @param string $modelName
     * @return string
     */
    protected static function injectUpdateRequestCode(string $modelName): string
    {
        /**
         * Get the fillables of the model
         */
        $fillables = Fillables::getFillables($modelName);

        /**
         * Update Request Code
         */
        $updateRequestCode = "";

        /**
         * Generate the update request code
         */
        foreach ($fillables as $fillable) {
            $updateRequestCode .= "'{$fillable}' => 'required',";
        }

        /**
         * return the generated code
         */
        return <<<EOT
            public function rules() : array
            {
                return [
                    {$updateRequestCode}
                ];
            }
        EOT;

    }

}