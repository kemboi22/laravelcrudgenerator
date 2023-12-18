<?php

namespace Kemboielvis\Laravelcrudgenerator\Helpers\Injector\Controllers;

use Kemboielvis\Laravelcrudgenerator\Helpers\Fillables;

class ControllerCodeInjector
{
    /**
     * Inject the index code
     *
     * @param string $modelName
     * @return string
     */
    protected static function injectIndexCode(string $modelName): string
    {
        /**
         * return the generated code
         */
        return <<<EOT
        public function index()
        {
            return response()->json([
                'message' => 'Retrieved successfully',
                'data' => {$modelName}::all()
            ], 200);
        }
        EOT;
    }

    /**
     * Inject the store code
     *
     * @param string $modelName
     * @return string
     */
    protected static function injectStoreCode(string $modelName): string
    {
        /**
         * Get the fillables of the model
         */
        $fillables = Fillables::getFillables($modelName);

        /**
         * Create the create code
         */
        $createCode = "";

        /**
         * Generate the create codee
         */
        foreach ($fillables as $fillable) {
            $createCode .= "{$fillable} => " . '$request->' . $fillable . ',';
        }
        /**
         * return  the generated code
         */
        return <<<EOT
        public function store(Store'.$modelName.'Request \$request)
        {
            \$created = {$modelName}::create([
                {$createCode}
            ]);
            
            return response()->json([
                'message' => 'Created successfully',
                'data' => \$created
            ], 201);          
        }
        EOT;
    }

    /**
     * Inject the show code
     *
     * @param string $modelName
     * @return string
     */

    protected static function injectShowCode(string $modelName): string
    {
        /**
         * return  the generated show code
         */
        return <<<EOT
        public function show(int \$id)
        {
            \{$modelName} = {$modelName}::find(\$id);
            if(!\{$modelName}){
                return response()->json([
                    'message' => 'Not found'
                ], 404);
            }
            return response()->json([
                'message' => 'Found successfully',
                'data' => \{$modelName}
            ], 200);          
        }
        EOT;
    }

    /**
     * Inject the update code
     *
     * @param string $modelName
     * @return string
     */

    protected static function injectUpdateCode(string $modelName): string
    {
        /**
         * Get the fillables of the model
         */
        $fillables = Fillables::getFillables($modelName);

        /**
         * Create the update code
         */
        $updateCode = "";

        /**
         * Generate the update codee
         */
        foreach ($fillables as $fillable) {
            $updateCode .= "{$fillable} => " . '$request->' . $fillable . ',';
        }
        /**
         * return  the generated code
         */
        return <<<EOT
        public function update(Update'.$modelName.'Request \$request, int \$id)
        {
            \{$modelName} = {$modelName}::find(\$id);
            if(!\{$modelName}){
                return response()->json([
                    'message' => 'Not found'
                ], 404);
            }
            \$update = \{$modelName}::update([
                {$updateCode}
            ]);            
            return response()->json([
                'message' => 'Updated successfully',
                'data' => \$update
            ], 201);          
        }
        EOT;
    }

    /**
     * Inject the destroy code
     *
     * @param string $modelName
     * @return string
     */

    protected static function injectDestroyCode(string $modelName): string
    {
        /**
         * return  the generated destroy code
         */
        return <<<EOT
        public function destroy(int \$id)
        {
            \{$modelName} = {$modelName}::find(\$id);
            if(!\{$modelName}){
                return response()->json([
                    'message' => 'Not found'
                ], 404);
            }
            if(!\{$modelName}->delete()){
                return response()->json([
                    'message' => 'An error occurred!! Not deleted'
                ], 500);
            }
            \{$modelName}->delete();
            return response()->json([
                'message' => 'Deleted successfully',
            ], 200);          
        }
        EOT;
    }

}