<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BLogController extends Controller
{	
	protected $limit = 3;

    public function index(){
    	$posts = Post::with('author')
                    ->latestFirst()
                    ->published()
                    ->simplePaginate($this->limit);

    	return view('blog.index',compact(['posts']));
    }

    public function category(Category $category)
    {

        $categoryName = $category->title;

        $posts = $category->posts()
                          ->with('author')
                          ->latestFirst()
                          ->published()
                          ->simplePaginate($this->limit);

         return view("blog.index", compact('posts','categoryName'));
    }

    public function show(Post $post){
    	// udate posts st view_count = view_count+1 where id = ?
    	// #way -> 1
    	// $viewCount = $post->view_count+1;
    	// $post->update(['view_count' => $viewCount]);

    	// #way -> 2
    	$post->increment('view_count');

    	return view('blog.show',compact('post'));
    }

    public function author(User $author){
    	$authorName = $author->name;

    	$posts = $author->posts()
    	                  ->with('category')
    	                  ->latestFirst()
    	                  ->published()
    	                  ->simplePaginate($this->limit);

    	 return view("blog.index", compact('posts','authorName'));
    }
}
