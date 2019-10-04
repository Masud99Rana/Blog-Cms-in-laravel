<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use App\Category;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {   

        // -> way 1
        // View::composer(
        //     'layouts.sidebar', 'App\Http\ViewComposers\NavigationViewComposer'
        // );

        // -> way 2
        View::composer('layouts.sidebar',function($view){
            $categories = Category::with(['posts'=>function($query){
                // $query->where('published_at', '<=', Carbon::now());
                $query->published(); //scope
            }])->orderBy('title','asc')->get();

            return $view->with('categories', $categories);
        });
    }
}
