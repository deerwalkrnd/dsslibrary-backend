<!DOCTYPE html>
<html>
<head>
    <title>Import Users</title>
</head>
<body>
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    <form action="{{ route('borrows.import') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="file" class="form-label">Choose Excel File (.xlsx)</label>
            <input type="file" name="file" class="form-control" accept=".xlsx" required>
        </div>

        <button type="submit" class="btn btn-primary">Import Books</button>
    </form>
</body>
</html>