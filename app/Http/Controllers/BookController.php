<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(
        protected BookService $bookService
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $perPage = $request->get('per_page', 10);
        return $this->bookService->all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        //
        return $this->bookService->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return $this->bookService->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        return $this->bookService->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, string $id)
    {
        //
        return $this->bookService->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        return $this->bookService->delete($id);
    }
}
