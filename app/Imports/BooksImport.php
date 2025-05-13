<?php
namespace App\Imports;

use App\Models\Book;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BooksImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                $validator = Validator::make($row->toArray(), [
                    'title'     => 'required|string',
                    'author'    => 'required|string',
                    'isbn'      => 'required|string',
                    'remaining' => 'required|integer',
                    'uuid'      => 'nullable',
                    'status'    => 'required|in:available,borrowed',
                ]);

                if ($validator->fails()) {
                    Log::warning('Validation failed for row:', $row->toArray());
                    continue;
                }

                Book::create([
                    'title'     => $row['title'],
                    'author'    => $row['author'],
                    'isbn'      => $row['isbn'],
                    'remaining' => $row['remaining'],
                    'uuid'      => $row['uuid'],
                    'status'    => $row['status'],
                ]);
            } catch (\Exception $e) {
                Log::error('Import error on row: ' . $e->getMessage(), ['row' => $row]);
            }
        }
    }
}
