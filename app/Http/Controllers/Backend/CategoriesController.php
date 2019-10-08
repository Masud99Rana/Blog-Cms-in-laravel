<?php

namespace App\Http\Controllers\Backend;

use App\Category;
use App\Http\Requests\CategoryDestroyRequest;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Post;
use Illuminate\Http\Request;

class CategoriesController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories      = Category::with('posts')->orderBy('title')->paginate($this->limit);
        $categoriesCount = Category::count();

        return view("backend.categories.index", compact('categories', 'categoriesCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();
        return view("backend.categories.create", compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        Category::create($request->all());

        return redirect("/backend/categories")->with("message", "New category was created successfully!");
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
        $category = Category::findOrFail($id);

        return view("backend.categories.edit", compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        Category::findOrFail($id)->update($request->all());

        return redirect("/backend/categories")->with("message", "Category was updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryDestroyRequest $request, $id)
    {
        Post::withTrashed()->where('category_id', $id)->update(['category_id' => config('cms.default_category_id')]);

        $category = Category::findOrFail($id);
        $category->delete();

        return redirect("/backend/categories")->with("message", "Category was deleted successfully!");
    }
}
