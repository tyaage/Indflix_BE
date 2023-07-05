<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGenreRequest;
use App\Http\Requests\UpdateGenreRequest;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all();
        return response()->json(['data' => $genres]);
    }

    public function create()
    {
        return view('admin.genre.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:genre,name'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'oldInput' => $request->all(),
                'message' => $validator->errors()
            ], 422);
        }

        // Menghasilkan slug berdasarkan nama
        $slug = Str::slug($request->name);

        $genre = new Genre();
        $genre->name = $request->name;
        $genre->slug = $slug;
        $genre->save();

        return response()->json(['message' => 'Genre telah berhasil dibuat!'], 200);
    }

    public function show(Genre $genre)
    {
        //
    }

    public function edit($id)
    {
        $genre = Genre::findOrFail($id);

        return response()->json($genre);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:genre,name,' . $id
        ]);

        if ($validator->fails()) {
            return response()->json([
                'oldInput' => $request->all(),
                'message' => $validator->errors()
            ], 422);
        }

        $genre = Genre::findOrFail($id);
        $genre->name = $request->name;
        $genre->slug = Str::slug($request->name);
        $genre->save();

        return response()->json(['message' => 'Genre telah berhasil diperbarui!'], 200);
    }

    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();

        return response()->json(['message' => 'Genre telah berhasil dihapus!'], 200);
    }
}
