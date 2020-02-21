<?php

namespace App\Http\Controllers\Backend;

use App\Tag;
use App\Http\Requests\TagDestroyRequest;
use App\Http\Requests\TagStoreRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Post;
use Illuminate\Http\Request;

class TagsController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags      = Tag::with('posts')->orderBy('name')->paginate($this->limit);
        $tagsCount = Tag::count();

        return view("backend.tags.index", compact('tags', 'tagsCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tag = new Tag();
        return view("backend.tags.create", compact('tag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagStoreRequest $request)
    {   
        Tag::create($request->all());

        return redirect("/backend/tags")->with("message", "New tag was created successfully!");
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
        $tag = Tag::findOrFail($id);

        return view("backend.tags.edit", compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagUpdateRequest $request, $id)
    {
        Tag::findOrFail($id)->update($request->all());

        return redirect("/backend/tags")->with("message", "Tag was updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
    
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect("/backend/tags")->with("message", "Tag was deleted successfully!");
    }
}
