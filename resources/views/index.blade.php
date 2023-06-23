<!-- resources/views/dashboard.blade.php -->

<h1>Welcome to the Dashboard!</h1>

<!-- Tambahkan tombol untuk menuju halaman pengaturan -->
@guest
    <a href="/login">Login</a>
@else
    <a href="/akun">Akun {{ $user->name }}</a>
    <form method="POST" action="/logout">
        @csrf
        <button type="submit">
            Logout
        </button>
    </form>
@endguest
