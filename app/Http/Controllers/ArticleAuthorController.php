<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\ArticleAuthorResource;
use App\Http\Resources\AuthorResource;
use Illuminate\Support\Facades\Gate;

class ArticleAuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function retrieveArticlesWithAuthors()
    {
        return ArticleAuthorResource::collection(Article::all());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function addArticleAuthor(string $articleId, string $authorId )
    {
        $response = Gate::inspect('manage');

        if ($response->allowed()) {
            // The action is authorized...
            $article = Article::findOrFail($articleId);
            $article->authors()->attach($authorId);
    
            return response()->json(['message' => 'Author added successfully.']);
            
        } else {
            $messgae = $response->message();
            return response()->json(['message' => $messgae]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function showArticleAuthors(string $id)
    {
        $response = Gate::inspect('manage');

        if ($response->allowed()) {
            // The action is authorized...
            $article = Article::findOrFail($id);
            $authors = $article->authors;
    
            return AuthorResource::collection($authors);
        } else {
            $messgae = $response->message();
            return response()->json(['message' => $messgae]);
        }

    }



    /**
     * Remove the specified resource from storage.
     */
    public function deleteArticleAuthor(string $articleId, string $authorId )
    {

        $response = Gate::inspect('manage');

        if ($response->allowed()) {
            // The action is authorized...
            $article = Article::findOrFail($articleId);
            $article->authors()->detach($authorId);
    
            return response()->json(['message' => 'Author deleted successfully from the atricle authors list.']);
        } else {
            $messgae = $response->message();
            return response()->json(['message' => $messgae]);
        }
    }
}
