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
        $book = Book::findOrFail($id);

        return $book->update($data);
    }

    public function delete(int $id): bool
    {
        $book = Book::findOrFail($id);

        return $book->delete();
    }

    public function find(int $id): ?Book
    {
        $book=Book::find($id);
        return $book;
    }

    public function paginate(int $perPage = 10):LengthAwarePaginator
{
    return Book::paginate($perPage);
}
}