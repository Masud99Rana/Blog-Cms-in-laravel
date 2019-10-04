<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
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
    	$categories = Category::with(['posts'=>function($query){
    		// $query->where('published_at', '<=', Carbon::now());
    		$query->published(); //scope
    	}])->orderBy('title','asc')->get();

        $categoryName = $category->title;

        $posts = $category->posts()
                          ->with('author')
                          ->latestFirst()
                          ->published()
                          ->simplePaginate($this->limit);

         return view("blog.index", compact('posts','categories','categoryName'));
    }

    public function show(Post $post){
    	return view('blog.show',compact('post'));
    }
}
