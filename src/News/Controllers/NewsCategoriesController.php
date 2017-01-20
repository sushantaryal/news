<?php

namespace Taggers\News\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Taggers\News\Models\NewsCategory;
use Illuminate\Foundation\Validation\ValidatesRequests;

class NewsCategoriesController extends Controller
{
    use ValidatesRequests;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = NewsCategory::all();

        return view('news::newscategories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);

        $category = NewsCategory::create([
            'title' => $request->input('title')
        ]);

        flash('Category has been added successfully.', 'success');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = NewsCategory::find($id);

        return view('news::newscategories.edit', compact('category'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);

        $category = NewsCategory::find($id);
        $category->title = $request->input('title');
        $category->save();

        flash('Category has been updated successfully.', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = NewsCategory::find($id);
        $category->delete();
        
        flash('Category has been deleted successfully.', 'success');
        return back();
    }
}
