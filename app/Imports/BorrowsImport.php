<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Book;
use App\Models\BorrowRecord;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BorrowsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                
                $validator = Validator::make($row->toArray(), [
                    'name'           => 'required|string|exists:users,name',
                    'title'          => 'required|string|exists:books,title',
                    'checkout_date'  => 'required|date',
                    'checkin_date'   => 'nullable|date|after_or_equal:checkout_date',
                ]);
                

                if ($validator->fails()) {
                    Log::warning('Validation failed for borrow record row', $row->toArray());
                    continue;
                }

                $user = User::where('name', $row['name'])->first();
                $book = Book::where('title', $row['title'])->first();

                if (!$user || !$book) {
                    Log::error("User or Book not found: " . $row['name'] . " / " . $row['title']);
                    continue;
                }

                BorrowRecord::create([
                    'user_id'       => $user->id,
                    'book_id'       => $book->id,
                    'checkout_date' => $row['checkout_date'],
                    'checkin_date'  => $row['checkin_date'],
                ]);
            } catch (\Exception $e) {
                Log::error('Import error on borrow record: ' . $e->getMessage(), ['row' => $row]);
            }
        }
    }
}
