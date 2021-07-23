<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Locales
    |--------------------------------------------------------------------------
    |
    | This value is the list of locales that your application will support
    |
    */
    'locales' => [
        'en',
        'ar',
        // 'es',
        // 'fr'
    ],

    /*
    |--------------------------------------------------------------------------
    | Directories
    |--------------------------------------------------------------------------
    |
    | This value is the list of directories where files with translatable strings are to be found
    | update them as per your needs.
    |
    */

    'directories' => [
        './resources/views',
        './resources/js/components',
        './app/Http/Controllers'
    ],

    /*
    |--------------------------------------------------------------------------
    | extensions
    |--------------------------------------------------------------------------
    |
    | This value is the list of extensions with corresponding regex to look for transalatable strings. 
    | you can add as many extensions as you want, just be sure to add the corresponding regex carefully
    |
    */

    'extensions' => [
        '.blade.php' => '/\@lang\(\'([A-Za-z .]*)\'\)|__\(\'([A-Za-z .]*)\'\)/',
        '.vue' => '/\{\{\s*\$t\(\'([A-z ]*)\'\)\s*}}/',
        '.php' => '/__trans\(\'([A-z 0-9 .<?>]*)/'
    ]
];