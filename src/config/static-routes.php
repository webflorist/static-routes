<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Output Path
    |--------------------------------------------------------------------------
    |
    | Set the output path for generated static routes.
    | Be sure to configure your web server to look here
    | first before looking in the public folder.
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
