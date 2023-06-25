<style>
    .container {
        max-width: 400px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
    }

    .form-group input[type="text"] {
        width: 100%;
        padding: 5px;
    }

    .form-group .error {
        color: red;
        font-size: 12px;
    }

    .btn {
        padding: 10px 20px;
        background-color: #3490dc;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #2779bd;
    }
</style>

<div class="container">
    <h1>Create Genre</h1>
    <a href="{{ route('genre.index') }}"><button class="btn">Back</button></a>
    <form action="{{ route('genre.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" required>
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn">Create</button>
    </form>
</div>
