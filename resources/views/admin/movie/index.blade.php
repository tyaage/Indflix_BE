<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
</style>

<h1>Movies</h1>
<a href="{{ route('admin.dashboard') }}"><button>Kembali</button></a>
<a href="{{ route('movie.create') }}"><button>Tambah Movie</button></a>

@if (session('success'))
    <div class="success-message">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="error-message">
        {{ session('error') }}
    </div>
@endif

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Genre</th>
            <th>Actor</th>
            <th>Synopsis</th>
            <th>Writer</th>
            <th>Year</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($movies as $movie)
            <tr>
                <td>{{ $movie->name }}</td>
                <td>
                    @foreach ($movie->genre as $gen)
                        {{ $gen->name }}
                    @endforeach
                </td>
                <td>{{ $movie->actor }}</td>
                <td>{{ \Illuminate\Support\Str::limit($movie->synopsis, 100) }}</td>
                <td>{{ $movie->writer }}</td>
                <td>{{ $movie->year }}</td>
                <td>
                    @if ($movie->image)
                        <img src="{{ asset($movie->image) }}" alt="Movie Image"
                            style="max-width: 100px; max-height: 100px;">
                    @else
                        No Image
                    @endif
                </td>
                <td>
                    <a href="{{ route('movie.edit', $movie->id) }}"><button>Edit</button></a>
                    <form action="{{ route('movie.destroy', $movie->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
