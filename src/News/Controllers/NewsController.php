<?php

namespace Taggers\News\Controllers;

use Image;
use Illuminate\Http\Request;
use Taggers\News\Models\News;
use Taggers\News\Models\NewsCategory;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::with('categories')->get();

        return view('news::news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = NewsCategory::pluck('title', 'id');

        return view('news::news.create', compact('categories'));
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

        $news = new News;
        $news->title       = $request->input('title');
        $news->description = $request->input('description');
        $news->status      = $request->input('status');

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $path = 'uploads/news/';
            $extension = $image->getClientOriginalExtension();
            $filename = generateFilename($path, $extension);

            // Upload Original
            $image = Image::make($image)->save($path . $filename);
            // Upload thumbnail
            $thumbimage = Image::make($image)->fit(350)->save($path . 'thumbs/' . $filename);

            if($image && $thumbimage) {
                $news->image = $path . $filename;
                $news->image_thumb = $path . 'thumbs/' . $filename;
            }
        }

        if($news->save()) {
            if($request->has('categories')) {
                $news->categories()->attach($request->input('categories'));
            }
            flash('News has been created successfully.', 'success');
            return back();
        }
        flash('News cannot be created at this moment.', 'danger');
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
        $categories = NewsCategory::pluck('title', 'id');
        $news = News::with('categories')->find($id);

        return view('news::news.edit', compact('categories', 'news'));
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

        $news = News::find($id);
        $news->title       = $request->input('title');
        $news->description = $request->input('description');
        $news->status      = $request->input('status');

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $path = 'uploads/news/';
            $extension = $image->getClientOriginalExtension();
            $filename = generateFilename($path, $extension);

            // Upload Original
            $image = Image::make($image)->save($path . $filename);
            // Upload thumbnail
            $thumbimage = Image::make($image)->fit(350)->save($path . 'thumbs/' . $filename);

            if($image && $thumbimage) {
                if($news->image && app('files')->exists($news->image)) {
                    app('files')->delete($news->image);
                    app('files')->delete($news->image_thumb);
                }

                $news->image = $path . $filename;
                $news->image_thumb = $path . 'thumbs/' . $filename;
            }
        }

        if($news->save()) {
            if($request->has('categories')) {
                $news->categories()->sync($request->input('categories'));
            }
            flash('News has been updated successfully.', 'success');
            return back();
        }
        flash('News cannot be updated at this moment.', 'danger');
        return back();
    }

    /**
     * Update publish status
     * 
     * @param  $id
     * @return Response
     */
    public function updateStatus($id)
    {
        $news = News::find($id);
        $news->status = ($news->status == 1) ? 0 : 1;
        $news->save();
        
        flash('Status has been updated successfully.', 'success');
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
        $news = News::find($id);
        $news->delete();

        flash('News has been deleted successfully.', 'success');
        return back();
    }
}
