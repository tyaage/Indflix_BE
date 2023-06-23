<!-- resources/views/dashboard.blade.php -->

<h1>Welcome to the Dashboard Admin!</h1>
<ul>
    <li><a href="/admin/movie">Movie</a></li>
    <li><a href="/admin/genre">Genre</a></li>
</ul>
<a href="{{ route('admin.pengaturan') }}">Pengaturan</a>
<form method="POST" action="/logout">
    @csrf
    <button type="submit">
        Logout
    </button>
</form>
