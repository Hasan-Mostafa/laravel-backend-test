<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\AuthorResource;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;


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

        $response = Gate::inspect('manage');
 
        if ($response->allowed()) {
            // The action is authorized...
            
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

        } else {
            $messgae = $response->message();
            return response()->json(['message' => $messgae]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        $response = Gate::inspect('manage');

        if ($response->allowed()) {
            // The action is authorized...
            return new AuthorResource($author);

        } else {
            $messgae = $response->message();
            return response()->json(['message' => $messgae]);
        }
        
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {

        $response = Gate::inspect('manage');

        if ($response->allowed()) {
            // The action is authorized...
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
        } else {
            $messgae = $response->message();
            return response()->json(['message' => $messgae]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $response = Gate::inspect('manage');

        if ($response->allowed()) {
            // The action is authorized...
            
            $author->delete();
    
            return response()->json(['message' => 'Author deleted successfully']);
            
        } else {
            $messgae = $response->message();
            return response()->json(['message' => $messgae]);
        }
    }
}
