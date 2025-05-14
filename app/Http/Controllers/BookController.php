<?php
namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Requests\SearchRequest;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(
        protected BookService $bookService
    ) {}

    /**
     * All
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
     * Post
     */
    public function store(BookRequest $request)
    {
        //
        return $this->bookService->create($request);
    }
    /**
     * Search
    */
    public function searchBooks(SearchRequest $request)
    {
        return $this->bookService->searchBooks($request);
    }

    /**
     * FindOne
     */
    public function show(string $id)
    {
        //
        return $this->bookService->find($id);
    }

    /**
     * Update
     */
    public function edit(string $id)
    {
        //
        return $this->bookService->find($id);
    }

    /**
     * Update
     */
    public function update(BookRequest $request, string $id)
    {
        //
        return $this->bookService->update($request, $id);
    }

    /**
     * Delete
     */
    public function destroy(string $id)
    {
        //
        return $this->bookService->delete($id);
    }
}
