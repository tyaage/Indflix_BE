<?php

namespace Database\Seeders;

use App\Models\Movie;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Movie::create([
            'name' => 'Oshi no Ko',
            'actor' => 'Ai, Aqua, Ruby, Arima Kana',
            'synopsis' => '',
            'writer' => 'admin',
            'year' => 'admin',
            'name' => 'Oshi no Ko',
            'actor' => 'Ai, Aqua, Ruby, Arima Kana',
            'synopsis' => 'In the entertainment world, celebrities often show exaggerated versions of themselves to the public, concealing their true thoughts and struggles beneath elaborate lies. Fans buy into these fabrications, showering their idols with undying love and support, until something breaks the illusion. Sixteen-year-old rising star Ai Hoshino of pop idol group B Komachi has the world captivated; however, when she announces a hiatus due to health concerns, the news causes many to become worried. As a huge fan of Ai, gynecologist Gorou Amemiya cheers her on from his countryside medical practice, wishing he could meet her in person one day. His wish comes true when Ai shows up at his hospital—not sick, but pregnant with twins! While the doctor promises Ai to safely deliver her children, he wonders if this encounter with the idol will forever change the nature of his relationship with her.',
            'writer' => 'Aka Akasaka',
            'year' => '2023',
        ]);
    }
}
