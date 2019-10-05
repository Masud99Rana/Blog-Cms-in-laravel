<?php

namespace App\Http\ViewComposers;

use App\Category;
use App\Post;
use Illuminate\View\View;

class NavigationViewComposer
{
    public function compose(View $view)
    {	
    	$this->composeCategories($view);
    	$this->composePopularPosts($view);  
    }

    private function composeCategories(View $view){

    	$categories = Category::with(['posts'=>function($query){
    	    $query->published(); //scope
    	}])->orderBy('title','asc')->get();

    	return $view->with('categories', $categories);
    }

    private function composePopularPosts(View $view){

    	$popularPosts = Post::published()->popular()->take(3)->get();
        return $view->with('popularPosts', $popularPosts);
    }
}