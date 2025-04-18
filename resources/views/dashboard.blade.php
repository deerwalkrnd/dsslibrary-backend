<html>
    <head>
        <title>Dashboard</title>
    </head>

    <body>
        <h1>Dashboard</h1>
        <p>Welcome to the dashboard, {{ auth()->user()->name }}!</p>
    </body>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger">
            Logout
        </button>
    </form>
</html>