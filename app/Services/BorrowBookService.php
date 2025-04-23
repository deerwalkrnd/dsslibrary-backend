<?php
namespace App\Services;

use App\Http\Requests\CheckInRequest;
use App\Http\Requests\CheckOutRequest;
use App\Repositories\Contracts\BorrowBookRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BorrowBookService
{
    public function __construct(
        protected BorrowBookRepositoryInterface $borrowBookRepository
    ) {
    }

    public function checkout(CheckOutRequest $request)
    {
        try {
            $data= $request->validated();
            $record = $this->borrowBookRepository->create($data);
            $book   = $record->book;
            if ($book->remaining > 0) {
                $book->remaining -= 1;
                $book->status = $book->remaining === 0 ? 'borrowed' : 'available';
                $book->save();
            } else {
                return response()->json(['message' => 'Book is not available'], 400);
            }
            return response()->json($record, 201);
        } catch (Exception $e) {
            Log::error('Checkout error: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function checkin(CheckInRequest $request, int $id)
    {
        try {
            $data   = $request->validated();
            $record = $this->borrowBookRepository->find($id);

            if (! $record || $record->checkin_date) {
                return response()->json(['message' => 'Invalid or already returned'], 400);
            }
            $updated = $this->borrowBookRepository->update($data, $id);

            if (! $updated) {
                return response()->json(['message' => 'Check-in failed'], 500);
            }

            return response()->json(['message' => 'Book returned'], 200);
        } catch (Exception $e) {
            Log::error('Check-in error: ' . $e->getMessage());
            return response()->json(['message' => 'Unexpected error during check-in'], 500);
        }
    }
    public function myBooks()
    {
        try {
            $userId = Auth::id();
            if (!$userId) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
    
            $books = $this->borrowBookRepository->getBooksBorrowedByUser($userId);
            return response()->json($books);
        } catch (Exception $e) {
            Log::error("Error getting books for user {$userId}: " . $e->getMessage());
            return response()->json(['message' => 'Could not fetch books'], 500);
        }
    }
    public function allBooks()
    {
        try {
            $books = $this->borrowBookRepository->getBooksBorrowed();
            return response()->json($books);
        } catch (Exception $e) {
            Log::error("Error getting books " . $e->getMessage());
            return response()->json(['message' => 'Could not fetch books'], 500);
        }
    }
}
