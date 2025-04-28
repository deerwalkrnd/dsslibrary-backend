<?php
namespace App\Repositories;

use App\Models\Book;
use App\Models\BorrowRecord;
use App\Repositories\Contracts\BorrowBookRepositoryInterface;

class BorrowBookRepository implements BorrowBookRepositoryInterface
{
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return BorrowRecord::all();
    }

    public function create(array $data): ?BorrowRecord
    {
        return BorrowRecord::create($data);
    }

    public function update(array $data, int $id): bool
    {
        $borrowRecord = BorrowRecord::findOrFail($id);
        return $borrowRecord->update($data);
    }

    public function delete(int $id): bool
    {
        $borrowRecord = BorrowRecord::findOrFail($id);

        return $borrowRecord->delete();
    }

    public function find(int $id): ?BorrowRecord
    {
        $borrowRecord = BorrowRecord::find($id);
        return $borrowRecord;
    }
    public function getBooksBorrowedByUser(int $userId,int $perPage=10)
    {
        return BorrowRecord::with('book')
            ->where('user_id', $userId)
            ->paginate($perPage);
    }
    public function getBooksBorrowed(int $perPage=10)
    {
        return BorrowRecord::with('book')
            ->paginate($perPage);
    }
}
