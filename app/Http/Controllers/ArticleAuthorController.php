<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\ArticleAuthorResource;
use App\Http\Resources\AuthorResource;

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
        $article = Article::findOrFail($articleId);
        $article->authors()->attach($authorId);

        return response()->json(['message' => 'Author added successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function showArticleAuthors(string $id)
    {
        $article = Article::findOrFail($id);
        $authors = $article->authors;

        return AuthorResource::collection($authors);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function deleteArticleAuthor(string $articleId, string $authorId )
    {
        $article = Article::findOrFail($articleId);
        $article->authors()->detach($authorId);

        return response()->json(['message' => 'Author deleted successfully from the atricle authors list.']);
    }
}
