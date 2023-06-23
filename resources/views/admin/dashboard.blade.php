<!-- resources/views/dashboard.blade.php -->

<h1>Welcome to the Dashboard Admin!</h1>

<a href="{{ route('admin.pengaturan') }}">Pengaturan</a>
<form method="POST" action="/logout">
    @csrf
    <button type="submit">
        Logout
    </button>
</form>
