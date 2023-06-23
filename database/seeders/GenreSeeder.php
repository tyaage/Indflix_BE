<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Aksi',
            'Animasi',
            'Petualangan',
            'Komedi',
            'Drama',
            'Fantasi',
            'Horor',
            'Musikal',
            'Misteri',
            'Romantis',
            'Fiksi Ilmiah',
            'Thriller',
            'Perang',
            'Sejarah',
            'Dokumenter',
        ];

        foreach ($genres as $genre) {
            Genre::create([
                'name' => $genre,
            ]);
        }
    }
}
