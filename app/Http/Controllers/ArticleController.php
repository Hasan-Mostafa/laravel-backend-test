<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\ArticleResource;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ArticleResource::collection(Article::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try
        {
            $request->validate([
                'title' => 'required',
                'article_text' => 'required',
                'image' => 'required|image'
            ]);
        } 
        catch (ValidationException $e)
        {
            return $e->validator->errors();
        }

        if ($request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('images', 'public'); 
        } else {
            return response()->json(['message' => 'Invalid image upload.'], 400);
        }

        $article = new Article();
        $article->title = $request->title;
        $article->date_of_publication = now();
        $article->article_text = $request->article_text;
        $article->image = $imagePath; // Save the image path
        
        $article->save();
        
        return response()->json(['message' => 'Article created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        try
        {
            $request->validate([
                'title' => 'required',
                'article_text' => 'required',
                'image' => 'required|image'
            ]);
        } 
        catch (ValidationException $e)
        {
            return $e->validator->errors();
        }

        if ($request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('images', 'public'); 
        } else {
            return response()->json(['message' => 'Invalid image upload.'], 400);
        }

        $article->title = $request->input('title');
        $article->article_text = $request->input('article_text');
        $article->image = $imagePath; // Save the image path

        $article->save();

        return response()->json(['message' => 'Article updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
         // Delete the associated image, if it exists
        if (!empty($article->image)) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return response()->json(['message' => 'Article deleted successfully']);
    }
}
