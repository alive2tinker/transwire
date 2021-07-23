# TransWire
translation has always been a pain point when working on multilingual laravel projects. whether it's missing strings or the fact that you have to switch between languages constantly while coding, the workflow just seems to be messy a bit. This package offers you a way to keep coding in a single language and when it is time to translate, just hit the command and all your strings will be translated or at least listed in a {locale}.json file waiting to be translated

installation
-----
you can install this package with composer:
```
composer require alive2tinker/transwire
```
The package will automatically register a service provider.

Next, you need to publish the WebSocket configuration file:
```
php artisan vendor:publish --provider="alive2tinker\TransWire\Providers\TransWireServiceProvider"
```
This is the default content of the config file that will be published as `config/transwire.php`

```
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
```
Usage
-----
when you are done with your frontend work wether it is blade or vue, or even backend work, simply run the following command:
```
php artisan transwire:translate
```
this command will fetch all strings from your files to be translated, and then store them nicely in a {locale}.json file located under ./resources/lang directory

Roadmap
----

- [x] initial functionality working properly
- [ ] get strings translated from a service provider such as Google Translate or Microsoft Translator. Or implement [LibreTranslate](https://libretranslate.com) service

License
-----
MIT
