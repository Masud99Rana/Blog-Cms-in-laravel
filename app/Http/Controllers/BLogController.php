<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class BLogController extends Controller
{	
	protected $limit = 3;

    public function index(){

    	$posts = Post::with('author')
                    ->latestFirst()
                    ->published()
                    ->simplePaginate($this->limit);

    	return view('blog.index',compact('posts'));
    }

    // public function show($id){

    // 	$post = Post::published()->findOrFail($id);
    // 	return view('blog.show',compact('post'));
    // }
    public function show(Post $post){
    	return view('blog.show',compact('post'));
    }
}
