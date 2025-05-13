<?php

namespace App\Http\Controllers;

use App\Imports\BooksImport;
use App\Imports\BorrowsImport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BulkUploadController extends Controller
{
    //
    public function usersImport(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls'
    ]);

    Excel::import(new UsersImport, $request->file('file'));

    return redirect('/')->with('success', 'All good!');
}

public function booksImport(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls'
    ]);

    Excel::import(new BooksImport, $request->file('file'));

    return redirect('/')->with('success', 'All good!');
}

public function borrowsImport(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls'
    ]);

    Excel::import(new BorrowsImport, $request->file('file'));

    return redirect('/')->with('success', 'All good!');
}

}
