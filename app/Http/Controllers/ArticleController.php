<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'DESC')->get();
        return view('pages.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.article.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image_cover' => 'required|mimes:jpg,jpeg,png|max:2048', // Maksimal 2MB (2048 KB)
        ], [
            'image_cover.required' => 'You must upload an image cover.',
            'image_cover.mimes' => 'The image cover must be a file of type: jpg, jpeg, png.',
            'image_cover.max' => 'The image cover may not be greater than 2MB.',
            'image_cover.uploaded' => 'The image cover does not comply with upload requirements.',
        ]);
        $imageImageCoverFile = $request->image_cover;
        $imageImageCoverName = "";
        if ($imageImageCoverFile !== null) {
            $imageImageCoverName = time() . '_' . $imageImageCoverFile->getClientOriginalName();
            $imageImageCoverFile->move(public_path('assets/images'), $imageImageCoverName);
            $this->zeroCrop(public_path('assets/images/' . $imageImageCoverName));
        }
        $data_insert = $request->all();
        $data_insert['image_cover'] = $imageImageCoverName;
        Article::create($data_insert);
        return redirect()->route('article.index')->with('success', 'Article added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $article = Article::findOrFail($id);
        // return view('pages.article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('pages.article.edit', compact('article'));
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
        $request->validate([
            'image_cover' => 'nullable|mimes:jpg,jpeg,png|max:2048', // Maksimal 2MB (2048 KB)
        ], [
            'image_cover.mimes' => 'The image cover must be a file of type: jpg, jpeg, png.',
            'image_cover.max' => 'The image cover may not be greater than 2MB.',
            'image_cover.uploaded' => 'The image cover does not comply with upload requirements.',
        ]);

        $article = Article::findOrFail($id);
        $data_insert = $request->all();
        if ($request->hasFile('image_cover')) {
            $oldImageCover = $article->image_cover;
            if ($oldImageCover && file_exists(public_path('assets/images/' . $oldImageCover))) {
                unlink(public_path('assets/images/' . $oldImageCover));
            }
            $imageCoverFile = $request->file('image_cover');
            $imageCoverName = time() . '_' . $imageCoverFile->getClientOriginalName();
            $imageCoverFile->move(public_path('assets/images'), $imageCoverName);
            $this->zeroCrop(public_path('assets/images/' . $imageCoverName));
            $data_insert['image_cover'] = $imageCoverName;
        }
        $article->update($data_insert);
        return redirect()->route('article.index')->with('success', 'Article updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $oldImageCover = $article->image_cover;
        if ($oldImageCover && file_exists(public_path('assets/images/' . $oldImageCover))) {
            unlink(public_path('assets/images/' . $oldImageCover));
        }
        $article->delete();
        return redirect()->route('article.index')->with('success', 'Article deleted successfully!');
    }
}
