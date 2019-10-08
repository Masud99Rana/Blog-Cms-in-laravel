<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\PostRequest;
use App\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class BlogController extends BackendController
{   
    protected $limit = 5;
    protected $uploadPath;

    public function __construct(){
        parent::__construct();
        // $this->uploadPath = public_path('app/img');
        $this->uploadPath = public_path(config('cms.image.directory'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if(($status = $request->get('status')) && $status == 'trash'){
            $posts = Post::onlyTrashed()->with('category','author')->latest()->paginate($this->limit);
            $allPostCount = Post::onlyTrashed()->count();

            $onlyTrashed = TRUE;
        }else{
            $posts = Post::with('category','author')->latest()->paginate($this->limit);
            $allPostCount = Post::count();
            $onlyTrashed = FALSE;


        }
        

        return view('backend.blog.index',compact('posts','allPostCount', 'onlyTrashed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Post $post)
    {   

        return view('backend.blog.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request){
    /*public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'excerpt' => 'required',
            'slug' => 'required|unique:posts',
            'body' => 'required',
            'published_at' => 'date_format:Y-m-d H:i:s',
            'category_id' => 'required'
        ]);*/
        $data = $this->handleRequest($request);
        $data['view_count'] = 0;

        $request->user()->posts()->create($data);

        return redirect('backend/blog')->with('message', 'Your post was created successfully!');
    }


    private function handleRequest($request){
        $data = $request->all();

        if($request->hasFile('image')){
            $image = $request->file('image');
            $fileName = $image ->getClientOriginalName();
            $destination = $this->uploadPath;
            $image->move($destination, $fileName);

            $successUploaded = $data['image'] = $fileName;

            if($successUploaded){
                $width = config('cms.image.thumbnail.width');
                $height = config('cms.image.thumbnail.height');

                $extention =$image->getClientOriginalExtension();
                $thumbnail = str_replace(".{$extention}", "_thumb.{$extention}", $fileName);

                Image::make($destination.'/'. $fileName)
                    ->resize($width,$height)
                    ->save($destination.'/'.$thumbnail);
            }
        }

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $post = Post::findOrFail($id);

        return view('backend.blog.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $data = $this->handleRequest($request);

        $post->update($data);

        return redirect('backend/blog')->with('message', 'Your post was updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::findOrFail($id)->delete();

        return redirect('backend/blog')->with('trash-message', ['Your post has been moved to Trash', $id]);
    }

    public function forceDestroy($id){
        Post::withTrashed()->findOrFail($id)->forceDelete();
        return redirect('backend/blog?status=trash')->with('message','Your post has been deleted successfully.');
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();

        return redirect('backend/blog')->with('message','Your post has been removed from Trash');
    }
}