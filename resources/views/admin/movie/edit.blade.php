<style>
    form {
        width: 400px;
        margin: 20px auto;
        font-family: Arial, sans-serif;
    }

    h1 {
        text-align: center;
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

    .current-image img {
        max-width: 100px;
        max-height: 100px;
        margin-right: 10px;
    }

    .delete-image-btn {
        background-color: #ff4d4f;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .delete-image-btn:hover {
        background-color: #ff7875;
    }
</style>

<h1>Edit Movie</h1>
<a href="{{ route('movie.index') }}"><button>Kembali</button></a>
<form action="{{ route('movie.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="name">Name:</label>
    <input type="text" name="name" value="{{ $movie->name }}" required>

    <label for="genres">Genre:</label>
    @foreach ($genres as $genre)
        <div class="genre-checkbox">
            <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                @if (in_array($genre->id, $selectedGenres)) checked @endif>
            <label for="genre">{{ $genre->name }}</label>
        </div>
    @endforeach

    <label for="actor">Actor:</label>
    <input type="text" name="actor" value="{{ $movie->actor }}" required>

    <label for="synopsis">Synopsis:</label>
    <textarea name="synopsis" required>{{ $movie->synopsis }}</textarea>

    <label for="writer">Writer:</label>
    <input type="text" name="writer" value="{{ $movie->writer }}" required>

    <label for="year">Year:</label>
    <input type="number" name="year" value="{{ $movie->year }}" required>

    <label for="minimum_age">Year:</label>
    <input type="number" name="minimum_age" value="{{ $movie->minimum_age }}" required>

    <label for="image">Image:</label>
    @if ($movie->image)
        <div class="current-image">
            <img src="{{ asset($movie->image) }}" alt="Movie Image">
            <button type="button" class="delete-image-btn">Delete Image</button>
        </div>
    @endif
    <input type="file" name="image">

    <label for="video">Video:</label>
    <input type="text" name="video" value="{{ $movie->video }}" required>

    <button type="submit">Update</button>
</form>

<script>
    // Script to handle delete image button
    const deleteImageButton = document.querySelector('.delete-image-btn');
    deleteImageButton.addEventListener('click', function() {
        const currentImageContainer = document.querySelector('.current-image');
        currentImageContainer.remove();

        // Set input value to trigger image deletion on the server
        const deleteImageInput = document.createElement('input');
        deleteImageInput.type = 'hidden';
        deleteImageInput.name = 'delete_image';
        deleteImageInput.value = '1';
        const form = document.querySelector('form');
        form.appendChild(deleteImageInput);
    });
</script>
