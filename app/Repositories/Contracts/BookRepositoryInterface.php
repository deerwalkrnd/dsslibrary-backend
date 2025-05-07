<?php

namespace App\Repositories\Contracts;

use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BookRepositoryInterface
{
    public function all(): \Illuminate\Database\Eloquent\Collection;

    public function create(array $data): ?Book;

    public function update(array $data, int $id): bool;

    public function delete(int $id): bool;

    public function find(int $id): ?Book;

    public function paginate(int $perPage = 10): LengthAwarePaginator;
}
