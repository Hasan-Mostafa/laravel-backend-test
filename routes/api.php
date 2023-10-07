<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleAuthorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Protected routes go here
    Route::post('/logout', [AuthController::class,'logout']);

    Route::apiResource('/author', AuthorController::class);

    Route::apiResource('/article', ArticleController::class);

    Route::get('/articles-authors', [ArticleAuthorController::class, 'retrieveArticlesWithAuthors']);
    Route::get('/articles-authors/{id}', [ArticleAuthorController::class, 'showArticleAuthors']);
    Route::post('/articles-authors/{articleId}/{authorId}', [ArticleAuthorController::class, 'addArticleAuthor']);
    Route::delete('/articles-authors/{articleId}/{authorId}', [ArticleAuthorController::class, 'deleteArticleAuthor']);

});
