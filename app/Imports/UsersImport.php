<?php
namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow
{
    public array $validationErrors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $rowArray = $row->toArray();

            $validator = Validator::make($rowArray, [
                'email'    => 'required|email|unique:users,email',
                'name'     => 'required|string',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                Log::info(
                $rowArray,$validator->errors()->all()
                );
                continue;
            }

            User::create([
                'name'     => $row['name'],
                'email'    => $row['email'],
                'password' => $row['password'],
                'role'     => 'student',
            ]);

        }
    }
}
