<?php

namespace App\Repositories\Contracts;

use App\Models\BorrowRecord;

interface BorrowBookRepositoryInterface
{
    public function all(): \Illuminate\Database\Eloquent\Collection;

    public function create(array $data): ?BorrowRecord;

    public function update(array $data, int $id): bool;

    public function delete(int $id): bool;

    public function find(int $id): ?BorrowRecord;
    public function getBooksBorrowedByUser(int $userId,int $perPage=10);
    public function getBooksBorrowed(int $perPage=10);
}
