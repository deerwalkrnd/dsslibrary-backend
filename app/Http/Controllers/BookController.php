<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(
        protected BookService $bookService
    ) {}

    /**
     * getMany Books
     */
    public function index(Request $request)
    {
        //
        return $this->bookService->all($request);
    }

    /**
     * create Book
     */
    public function create()
    {
        //
    }

    /**
     * post Book
     */
    public function store(BookRequest $request)
    {
        //
        return $this->bookService->create($request);
    }

    /**
     * findOne Book
     */
    public function show(string $id)
    {
        //
        return $this->bookService->find($id);
    }

    /**
     * updateBook
     */
    public function edit(string $id)
    {
        //
        return $this->bookService->find($id);
    }

    /**
     * update Book
     */
    public function update(BookRequest $request, string $id)
    {
        //
        return $this->bookService->update($request, $id);
    }

    /**
     * delete Book
     */
    public function destroy(string $id)
    {
        //
        return $this->bookService->delete($id);
    }
}
