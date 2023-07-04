<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function index()
    {
        $bannerMovies = DB::table('movie')
            ->whereNotNull('image')
            ->inRandomOrder()
            ->limit(5) // Ubah jumlah film yang ingin ditampilkan sebagai banner
            ->get();

        $popularMovies = Movie::orderBy('likes', 'desc')->take(10)->get();

        $newestMovies = Movie::orderBy('created_at', 'desc')->take(10)->get();

        $data = [
            'bannerMovies' => $bannerMovies,
            'popularMovies' => $popularMovies,
            'newestMovies' => $newestMovies,
        ];

        return response()->json($data, Response::HTTP_OK);

        // return view('index', compact('user', 'bannerMovies', 'popularMovies', 'newestMovies'));
    }

}
