<?php

namespace SuperTools;

use Illuminate\Support\ServiceProvider;

class SuperToolsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('superTools', function () {
            return new SuperTools();
        });    
    }

    public function boot()
    {
        // 
    }
}
