<?php

namespace App\Http\ViewComposers;

use App\Category;
class NavigationViewComposer
{
    public function compose($view)
    {
        $categories = Category::with(['posts'=>function($query){
            // $query->where('published_at', '<=', Carbon::now());
            $query->published(); //scope
        }])->orderBy('title','asc')->get();

        return $view->with('categories', $categories);
    }
}