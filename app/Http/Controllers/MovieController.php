<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movie::with('genre')->get();

        return response()->json(['data' => $movies]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genres = Genre::all();
        return response()->json(['data' => $genres]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'actor' => 'required',
            'synopsis' => 'required',
            'writer' => 'required',
            'year' => 'required|integer',
            'image' => 'nullable|image|max:2048', // Batasan maksimum ukuran file adalah 2MB (2048 KB)
            'genres' => 'required|array',
            'genres.*' => 'exists:genre,id',
            'minimum_age' => 'required|integer',
            'video' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'oldInput' => $request->all(),
                'errors' => $validator->errors()
            ], 422);
        }

        // Menghasilkan slug berdasarkan nama
        $validatedData['slug'] = Str::slug($request->input('name'));
        $validatedData['name'] = $request->input('name');
        $validatedData['actor'] = $request->input('actor');
        $validatedData['synopsis'] = $request->input('synopsis');
        $validatedData['writer'] = $request->input('writer');
        $validatedData['year'] = $request->input('year');
        $validatedData['genres'] = $request->input('genres');
        $validatedData['minimum_age'] = $request->input('minimum_age');
        $validatedData['video'] = $request->input('video');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('public/images');
            $validatedData['image'] = Storage::url($imagePath);
        }

        $movie = Movie::create($validatedData);

        $movie->genre()->attach($validatedData['genres']);

        return response()->json([
            'message' => 'Movie created successfully.'
        ], 200);
    }


    public function store_(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'actor' => 'required',
            'synopsis' => 'required',
            'writer' => 'required',
            'year' => 'required|integer',
            'image' => 'nullable|image|max:2048', // Batasan maksimum ukuran file adalah 2MB (2048 KB)
            'genres' => 'required|array',
            'genres.*' => 'exists:genre,id',
            'minimum_age' => 'required|integer',
            'video' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'oldInput' => $request->all(),
                'errors' => $validator->errors()
            ], 422);
        }

        // Menghasilkan slug berdasarkan nama
        $validatedData['slug'] = Str::slug($validator['name']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $validatedData['image'] = Storage::url($imagePath);
        }

        $movie = Movie::create($validatedData);

        $movie->genre()->attach($validatedData['genres']);

        return response()->json([
            'message' => 'Movie created successfully.'
        ], 200);
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
            'minimum_age' => 'required|integer',
            'video' => 'required|url',
        ]);

        if ($request->has('delete_image')) {
            $this->deleteMovieImage($movie);
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $validatedData['image'] = Storage::url($imagePath);
        }

        // Update slug based on name
        $validatedData['slug'] = Str::slug($validatedData['name']);

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

    /**
     * Display the specified resource.
     */
    public function show($movie)
    {
        $movie = Movie::where('slug', $movie)->firstOrFail();

         // Ambil informasi pengguna (misalnya dari sesi atau autentikasi)
        $user = Auth::user();
        $userBirthYear = $user->birth_year;
        $userAge = date('Y') - $userBirthYear;

        $minimum_age = $movie->minimum_age;
        $isAllowed = $userAge >= $minimum_age;

        // Cek apakah pengguna memenuhi batasan umur film
        if ($isAllowed) {
            return view('movie', compact('movie'));
        } else {
            return redirect()->back()->with('message', 'Anda tidak memenuhi batasan umur untuk menonton film ini.');
        }
    }

    public function like($slug)
    {
        $movie = Movie::where('slug', $slug)->first();

        if ($movie) {
            $movie->likes += 1;
            $movie->save();

        return redirect()->back()->with('success', 'You liked the movie!');
    }

        return redirect()->back()->with('error', 'Movie not found.');
    }
}
