<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $movies = Movie::all();

        // return view('admin.movie.index', compact('movies'));
        $movies = Movie::with('genre')->get();

        return view('admin.movie.index', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genres = Genre::all();
        return view('admin.movie.create', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'actor' => 'required',
            'synopsis' => 'required',
            'writer' => 'required',
            'year' => 'required|integer',
            'image' => 'nullable|image|max:2048', // Batasan maksimum ukuran file adalah 2MB (2048 KB)
            'genres' => 'required|array',
            'genres.*' => 'exists:genre,id',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $validatedData['image'] = Storage::url($imagePath);
        }

        $movie = Movie::create($validatedData);

        $movie->genre()->attach($validatedData['genres']);

        return redirect()->route('movie.index')->with('success', 'Movie created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        $genres = Genre::all(); // Mengambil semua genre dari tabel genre
        $selectedGenres = $movie->genre->pluck('id')->toArray(); // Mengambil ID-genre yang sudah terhubung dengan film
        return view('admin.movie.edit', compact('movie', 'genres', 'selectedGenres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'actor' => 'required',
            'synopsis' => 'required',
            'writer' => 'required',
            'year' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'genres' => 'required|array',
            'genres.*' => 'exists:genre,id',
        ]);

        if ($request->has('delete_image')) {
            $this->deleteMovieImage($movie);
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $validatedData['image'] = Storage::url($imagePath);
        }

        $movie->update($validatedData);

        $movie->genre()->sync($validatedData['genres']); // Menggantikan attach() dengan sync() untuk memperbarui hubungan genre

        return redirect()->route('movie.index')->with('success', 'Movie updated successfully.');
    }

    private function deleteMovieImage($movie)
    {
        if ($movie->image) {
            // Hapus gambar dari storage
            Storage::delete('public/images/' . basename($movie->image));

            // Hapus tautan gambar dari basis data
            $movie->image = null;
            $movie->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();

        return redirect()->route('movie.index')->with('success', 'Movie deleted successfully.');

    }
}
