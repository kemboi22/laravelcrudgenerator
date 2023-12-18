<?php

namespace Kemboielvis\Laravelcrudgenerator\Helpers\Injector\Controllers;

use Kemboielvis\Laravelcrudgenerator\Helpers\Fillables;

class StoreCodeInjector
{


    /**
     * Store code injector
     */

    public static function storeCode(string $modelName): string
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
            $createCode .= "{$fillable} => ".'$request->'.$fillable.',';
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



}