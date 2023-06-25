<style>
    .movie-container {
        width: 400px;
        margin: 20px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .movie-container h2 {
        color: #333;
        font-size: 24px;
        margin-bottom: 10px;
    }

    .movie-container p {
        color: #666;
        font-size: 16px;
        margin-bottom: 5px;
    }

    .movie-container img {
        max-width: 100px;
        max-height: 100px;
        margin-bottom: 10px;
    }

    .movie-container ul {
        margin-left: 20px;
    }

    .movie-container li {
        color: #666;
        font-size: 14px;
        margin-bottom: 5px;
    }
</style>

<button>
    <a href="/">
        Kembali
    </a>
</button>
<div class="movie-container">
    <h2>{{ $movie->name }}</h2>

    <p>{{ $movie->synopsis }}</p>

    <p>Actors: {{ $movie->actor }}</p>
    <p>Writer: {{ $movie->writer }}</p>
    <p>Year: {{ $movie->year }}</p>

    <!-- Tampilkan gambar film jika tersedia -->
    @if ($movie->image)
        <img src="{{ asset($movie->image) }}" alt="Movie Image">
    @else
        No Image
    @endif

    <!-- Tampilkan genre film jika tersedia -->
    @if ($movie->genre->count() > 0)
        <p>Genre:</p>
        <ul>
            @foreach ($movie->genre as $genre)
                <li>{{ $genre->name }}</li>
            @endforeach
        </ul>
    @endif

    <p>Total Likes: {{ $movie->likes }}</p>

    <!-- Add like button -->
    <form action="/{{ $movie->slug }}/like">
        @csrf
        <button type="submit">Like</button>
    </form>

    <!-- Tampilkan video menggunakan HTML5 Video Player -->
    <div class="video-container">
        <video controls>
            <source src="{{ $movie->video }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

</div>
