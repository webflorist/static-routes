<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Output Path
    |--------------------------------------------------------------------------
    |
    | Set the output path for generated static routes.
    |
    */
    'output_path' => storage_path('static_routes'),

    /*
    |--------------------------------------------------------------------------
    | Excluded Paths
    |--------------------------------------------------------------------------
    |
    | Set array of paths to exclude from generation.
    | Any routes starting with these paths will be excluded from generation.
    |
    */
    'excluded_paths' => [
        'api'
    ],

];
