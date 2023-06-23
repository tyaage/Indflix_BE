<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" autofocus>
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>
    <a href="/register">Register</a>
</body>

</html>
