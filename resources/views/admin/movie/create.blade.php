<style>
    form {
        width: 400px;
        margin: 20px auto;
        font-family: Arial, sans-serif;
    }

    label {
        display: block;
        margin-top: 10px;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-top: 5px;
        margin-bottom: 10px;
        resize: vertical;
    }

    input[type="number"],
    input[type="file"] {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        margin-bottom: 10px;
        box-sizing: border-box;
    }

    select[multiple] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-top: 5px;
        margin-bottom: 10px;
        resize: vertical;
        height: auto;
    }

    button[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }

    .genre-checkbox {
        display: inline-block;
        margin-right: 10px;
    }
</style>


<h1>Add Movie</h1>
<a href="{{ route('movie.index') }}"><button>Kembali</button></a>
<form action="{{ route('movie.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="name">Name:</label>
    <input type="text" name="name" required>

    <label for="genres">Genres:</label>
    @foreach ($genres as $genre)
        <div class="genre-checkbox">
            <input type="checkbox" name="genres[]" value="{{ $genre->id }}">
            <label for="genre">{{ $genre->name }}</label>
        </div>
    @endforeach

    <label for="actor">Actor:</label>
    <input type="text" name="actor" required>

    <label for="synopsis">Synopsis:</label>
    <textarea name="synopsis" required></textarea>

    <label for="writer">Writer:</label>
    <input type="text" name="writer" required>

    <label for="year">Year:</label>
    <input type="number" name="year" required>

    <label for="image">Image:</label>
    <input type="file" name="image">

    <button type="submit">Add</button>
</form>
