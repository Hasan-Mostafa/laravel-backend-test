<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\AuthorResource;
use Illuminate\Validation\Rule;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AuthorResource::collection(Author::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try
        {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:authors',
                'country' => 'required',
            ]);
        } 
        catch (ValidationException $e)
        {
            return $e->validator->errors();
        }

        $author = Author::create([
            'name' => $request->name,
            'email' => $request->email,
            'country' => $request->country,
        ]);


        return response()->json(['message' => 'Author created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return new AuthorResource($author);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        try
        {
            $request->validate([
                'name' => 'required',
                'email' =>  [
                    'required',
                    'email',
                    Rule::unique('authors')->ignore($author->id),
                ],
                'country' => 'required',
            ]);
        } 
        catch (ValidationException $e)
        {
            return $e->validator->errors();
        }

        // update the author
        $author->name = $request->name;
        $author->email = $request->email;
        $author->country = $request->country;
        $author->save();

        return response()->json(['message' => 'Author updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return response()->json(['message' => 'Author deleted successfully']);
    }
}
