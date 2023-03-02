<?php

namespace Super;

use Illuminate\Support\ServiceProvider;

class SuperToolsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('super-tools', function () {
            return new SuperTools();
        });    
    }

    public function boot()
    {
        // 
    }
}
