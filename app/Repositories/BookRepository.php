<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Contracts\BookRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BookRepository implements BookRepositoryInterface
{
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return Book::all();
    }

    public function create(array $data): ?Book
    {
        return Book::create($data);
    }

    public function update(array $data, int $id): bool
    {
        $Book = Book::findOrFail($id);

        return $Book->update($data);
    }

    public function delete(int $id): bool
    {
        $Book = Book::findOrFail($id);

        return $Book->delete();
    }

    public function find(int $id): ?Book
    {
        $Book=Book::find($id);
        return $Book;
    }

    public function paginate(int $perPage = 10):LengthAwarePaginator
{
    return Book::paginate($perPage);
}
}