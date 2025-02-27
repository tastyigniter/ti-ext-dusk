<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Dusk screenshots folder
    |--------------------------------------------------------------------------
    |
    | Defines the directory to save screenshots for failed Dusk tests.
    |
    */
    'screenshotsPath' => storage_path('dusk/screenshots'),

    /*
    |--------------------------------------------------------------------------
    | Dusk console folder
    |--------------------------------------------------------------------------
    |
    | Defines the directory to save console logs for failed Dusk tests.
    |
    */
    'consolePath' => storage_path('dusk/console'),
];
