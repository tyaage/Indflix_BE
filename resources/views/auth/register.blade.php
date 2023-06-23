<!-- resources/views/register.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
</head>

<body>
    <h2>Register</h2>

    @if (isset($message))
        <p>{{ $message }}</p>
    @endif

    @if (isset($user))
        <p>User: {{ $user }}</p>
    @endif

    <form method="POST" action="/register">
        @csrf

        <div>
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" required>
            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <div>
            <label for="gender">Gender</label>
            <select name="gender" required>
                <option value="L">Male</option>
                <option value="P">Female</option>
            </select>
            @error('gender')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="birth_year">Birth Year</label>
            <input type="text" name="birth_year" value="{{ old('birth_year') }}" required>
            @error('birth_year')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <button type="submit">Register</button>
        </div>
    </form>
</body>

</html>
