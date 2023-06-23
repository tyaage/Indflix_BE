<style>
    .form-group {
        margin-bottom: 20px;
    }

    .error-message {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }
</style>

<h1>Edit Genre</h1>
<a href="{{ route('genre.index') }}"><button>Back</button></a>
<form action="{{ route('genre.update', $genre->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $genre->name }}" required>
        @error('name')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit">Update</button>
</form>
