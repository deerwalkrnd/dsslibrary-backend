<!DOCTYPE html>
<html>
<head>
    <title>Import Users</title>
</head>
<body>
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="file">Choose Excel File:</label>
        <input type="file" name="file" id="file" required accept=".xlsx,.xls">
        <br><br>
        <button type="submit">Import Users</button>
    </form>
</body>
</html>
