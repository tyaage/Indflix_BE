<style>
    .form-container {
        border: 1px solid #ccc;
        padding: 20px;
        margin-bottom: 20px;
    }

    .form-container label,
    .form-container input,
    .form-container select {
        display: block;
        margin-bottom: 10px;
    }
</style>

<a href="/">Kembali</a>

<!-- Menampilkan pesan sukses -->
@if (session('profile-success'))
    <div class="alert alert-success">
        {{ session('profile-success') }}
    </div>
@endif

<!-- Menampilkan pesan validasi untuk form profil -->
@if ($errors->any(['name', 'email', 'gender', 'birth_year']))
    <div class="alert alert-danger">
        <ul>
            @foreach (['name', 'email', 'gender', 'birth_year'] as $field)
                @foreach ($errors->get($field) as $error)
                    <li>{{ $error }}</li>
                @endforeach
            @endforeach
        </ul>
    </div>
@endif

<div class="form-container">
    <form method="POST" action="/ubah-profile">
        @csrf
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ $user->name }}">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ $user->email }}">

        <label for="gender">Gender</label>
        <select name="gender" id="gender">
            <option value="L" {{ $user->gender === 'L' ? 'selected' : '' }}>Male</option>
            <option value="P" {{ $user->gender === 'P' ? 'selected' : '' }}>Female</option>
        </select>

        <label for="birth_year">Birth Year</label>
        <input type="number" name="birth_year" id="birth_year" value="{{ $user->birth_year }}">

        <button type="submit">Update Profile</button>
    </form>
</div>


<!-- Menampilkan pesan sukses -->
@if (session('password-success'))
    <div class="alert alert-success">
        {{ session('password-success') }}
    </div>
@endif

<!-- Menampilkan pesan validasi untuk form ubah password -->
@if ($errors->any(['current_password', 'new_password', 'new_password_confirmation']))
    <div class="alert alert-danger">
        <ul>
            @foreach (['current_password', 'new_password', 'new_password_confirmation'] as $field)
                @foreach ($errors->get($field) as $error)
                    <li>{{ $error }}</li>
                @endforeach
            @endforeach
        </ul>
    </div>
@endif

<div class="form-container">
    <form method="POST" action="/ubah-password">
        @csrf
        <label for="current_password">Current Password</label>
        <input type="password" name="current_password" id="current_password">

        <label for="new_password">New Password</label>
        <input type="password" name="new_password" id="new_password">

        <label for="new_password_confirmation">Confirm Password</label>
        <input type="password" name="new_password_confirmation" id="new_password_confirmation">

        <button type="submit">Change Password</button>
    </form>
</div>
