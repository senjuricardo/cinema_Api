<?php

namespace App\Http\Controllers;

use App\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response()->json(Movie::with(['actors','genres'])->get(), 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $movie = Movie::create($request->all());
            $movie->actors()->sync($request->actors);
            $movie->genres()->sync($request->genres);
            return response()->json($movie, 201);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        try{
            return response()->json($movie->load(['genres','actors']),200);
        } catch(\Exception $exception){
            return response()->json(['error' =>$exception],500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {

        try {
            $movie->update($request->all());
            $movie->actors()->sync($request->actors);
            $movie->genres()->sync($request->genres);
            return response()->json($movie->load(['genres','actors']),201);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        try {
            $movie->delete();
            return response()->json(['message' => 'Deleted'], 205);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }
}
