<?php

namespace alive2tinker\TransWire\Providers;

use alive2tinker\TransWire\Console\Commands\Translate;
use Illuminate\Support\ServiceProvider;

class TransWireServiceProvider extends ServiceProvider
{
    public function register(){
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'transwire');
    }

    public function boot()
    { 
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('transwire.php'),
              ], 'config');

            $this->commands([
                Translate::class
            ]);
        }
    }
}