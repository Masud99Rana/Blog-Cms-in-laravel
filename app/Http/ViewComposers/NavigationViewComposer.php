<?php

namespace App\Http\ViewComposers;

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\View\View;

class NavigationViewComposer
{
    public function compose(View $view)
    {	
    	$this->composeCategories($view);
        $this->composeTags($view);
        $this->composeArchives($view);
    	$this->composePopularPosts($view);  
    }

    private function composeCategories(View $view){

    	$categories = Category::with(['posts'=>function($query){
    	    $query->published(); //scope
    	}])->orderBy('title','asc')->get();

    	return $view->with('categories', $categories);
    }

    private function composeTags(View $view){

        $tags = Tag::has('posts')->get(); // posts ralationship day
        return $view->with('tags', $tags);
    }

    private function composeArchives(View $view)
    {
        $archives = Post::archives();

        $view->with('archives', $archives);
    }

    private function composePopularPosts(View $view){

    	$popularPosts = Post::published()->popular()->take(3)->get();
        return $view->with('popularPosts', $popularPosts);
    }
}