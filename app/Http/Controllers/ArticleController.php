<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\ArticleResource;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Gate::inspect('manage');

        if ($response->allowed()) {
            // The action is authorized...
            return ArticleResource::collection(Article::all());
            
        } else {
            $messgae = $response->message();
            return response()->json(['message' => $messgae]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $response = Gate::inspect('manage');

        if ($response->allowed()) {
            // The action is authorized...
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
        } else {
            $messgae = $response->message();
            return response()->json(['message' => $messgae]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $response = Gate::inspect('manage');

        if ($response->allowed()) {
            // The action is authorized...
            return new ArticleResource($article);
        } else {
            $messgae = $response->message();
            return response()->json(['message' => $messgae]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $response = Gate::inspect('manage');

        if ($response->allowed()) {
            // The action is authorized...
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
        } else {
            $messgae = $response->message();
            return response()->json(['message' => $messgae]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {

        $response = Gate::inspect('manage');

        if ($response->allowed()) {
            // The action is authorized...
            // Delete the associated image, if it exists
           if (!empty($article->image)) {
               Storage::disk('public')->delete($article->image);
           }
    
           $article->delete();
    
           return response()->json(['message' => 'Article deleted successfully']);
            
        } else {
            $messgae = $response->message();
            return response()->json(['message' => $messgae]);
        }

    }
}
