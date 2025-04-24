<?php
namespace App\Services;

use App\Http\Requests\BookRequest;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\Contracts\BorrowBookRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookService
{
    public function __construct(
        protected BookRepositoryInterface $bookRepository
    ) {
    }

    public function create(BookRequest $request)
    {
        try {
            $data = $request->validated();
            $book = $this->bookRepository->create($data);

            if (!$book) {
                return response()->json(['message' => 'Book creation failed'], 500);
            }

            return response()->json($book, 201);

        } catch (QueryException $e) {
            Log::error('Database error during book creation: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        } catch (Exception $e) {
            Log::error('Unexpected error during book creation: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(BookRequest $request, int $id)
    {
        try {
            $data = $request->validated();
            $book = $this->bookRepository->update($data, $id);

            if (!$book) {
                return response()->json(['message' => 'Update failed'], 500);
            }

            return response()->json($data, 200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Book not found'], 404);
        } catch (Exception $e) {
            Log::error('Error updating book: ' . $e->getMessage());
            return response()->json(['message' => 'Unexpected error'], 500);
        }
    }

    public function delete(int $id)
    {
        try {
            $deleted = $this->bookRepository->delete($id);

            if (!$deleted) {
                return response()->json(['message' => 'Delete failed'], 500);
            }

            return response()->json(['message' => 'Book deleted'], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Book not found'], 404);
        } catch (Exception $e) {
            Log::error('Error deleting book: ' . $e->getMessage());
            return response()->json(['message' => 'Unexpected error'], 500);
        }
    }

    public function all(Request $request)
{
    try {
        $perPage = (int) $request->get('perPage',10);
        return response()->json($this->bookRepository->paginate($perPage));
    } catch (Exception $e) {
        Log::error('Error fetching books: ' . $e->getMessage());
        return response()->json(['message' => 'Could not fetch books'], 500);
    }
}

    public function find(int $id)
    {
        try {
            $book = $this->bookRepository->find($id);

            if (!$book) {
                return response()->json(['message' => 'Book not found'], 404);
            }

            return response()->json($book, 200);
        } catch (Exception $e) {
            Log::error('Error fetching book: ' . $e->getMessage());
            return response()->json(['message' => 'Unexpected error'], 500);
        }
    }
}