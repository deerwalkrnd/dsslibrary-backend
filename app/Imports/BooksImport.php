<?php
namespace App\Imports;

use App\Models\Book;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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
                    'remaining' => 'required|integer',
                    'status'    => 'required|in:available,borrowed',
                ]);

                if ($validator->fails()) {
                    dd($row->toArray(),$validator->errors()->all());
                    continue;
                }
                $uuid= Str::uuid()->toString();

                Book::create([
                    'title'     => $row['title'],
                    'author'    => $row['author'],
                    'remaining' => $row['remaining'],
                    'uuid'      => $uuid,
                    'status'    => $row['status'],
                ]);
            } catch (\Exception $e) {
                dd('Import error on row: ' . $e->getMessage(), ['row' => $row]);
            }
        }
    }
}
