<?php
namespace App\Repositories;

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

    public function search(int $perPage = 10, string $search)
    {
        $books = BorrowRecord::whereHas('book', function ($query) use ($search) {
            $query->where('title', 'like', "$search%");
        })->with('book','user')->latest()->paginate($perPage);
        return $books;
    }

    public function getBooksBorrowedByUser(int $userId, int $perPage = 10)
    {
        return BorrowRecord::with('book','user')
            ->where('user_id', $userId)
            ->paginate($perPage);
    }

    public function getBooksBorrowed(int $perPage = 10)
    {
        return BorrowRecord::with('book')->latest()
            ->paginate($perPage);
    }

    public function getOverdueBooks(int $perPage = 10)
    {
       return BorrowRecord::with('book','user')
        ->whereNull('checkin_date')
        ->where('checkout_date', '<=', now()->subDays(15))
        ->latest()
        ->paginate($perPage);
    }

    public function searchOverdueBooks(int $perPage = 10, string $search)
    {
        $books = BorrowRecord::whereHas('book', function ($query) use ($search) {
            $query->where('title', 'like', "$search%");
        })->whereNull('checkin_date')
        ->where('checkout_date', '<=', now()->subDays(15))->with('book','user')->latest()->paginate($perPage);
        return $books;
    }
}
