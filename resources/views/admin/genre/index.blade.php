<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .btn {
        display: inline-block;
        padding: 6px 12px;
        margin-bottom: 0;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.42857143;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        cursor: pointer;
        background-image: none;
        border: 1px solid transparent;
        border-radius: 4px;
        color: #fff;
        background-color: #337ab7;
        border-color: #2e6da4;
    }

    .btn:hover {
        background-color: #286090;
        border-color: #204d74;
    }

    .btn-danger {
        background-color: #d9534f;
        border-color: #d43f3a;
    }

    .btn-danger:hover {
        background-color: #c9302c;
        border-color: #ac2925;
    }
</style>
<h1>Genre List</h1>
<a href="{{ route('admin.dashboard') }}"><button>Kembali</button></a>
<a href="{{ route('genre.create') }}"><button>Create Genre</button></a>

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

@if ($genres->count() > 0)
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($genres as $genre)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $genre->name }}</td>
                    <td>
                        <a href="{{ route('genre.edit', $genre->id) }}">Edit</a>
                        <form action="{{ route('genre.destroy', $genre->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Are you sure you want to delete this genre?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No genres found.</p>
@endif
