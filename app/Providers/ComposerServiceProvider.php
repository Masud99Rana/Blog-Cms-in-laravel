<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Http\ViewComposers\NavigationViewComposer;

class ComposerServiceProvider extends ServiceProvider
{
    public function register()
    {        
    }

    public function boot()
    {   
        view()->composer('layouts.sidebar', NavigationViewComposer::class);
    }
}
