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

        $slugs = [
            'aksi',
            'animasi',
            'petualangan',
            'komedi',
            'drama',
            'fantasi',
            'horor',
            'musikal',
            'misteri',
            'romantis',
            'fiksi-ilmiah',
            'thriller',
            'perang',
            'sejarah',
            'dokumenter',
        ];

        $genresWithSlugs = array_combine($genres, $slugs);

        foreach ($genresWithSlugs as $name => $slug) {
            Genre::create([
                'name' => $name,
                'slug' => $slug,
            ]);
        }
    }
}
