<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckInRequest;
use App\Http\Requests\CheckOutRequest;
use App\Http\Requests\SearchRequest;
use App\Services\BorrowBookService;
use Illuminate\Http\Request;

class BorrowBookController extends Controller
{
    public function __construct(
        protected BorrowBookService $borrowBookService
    ) {}
    /**
     * Checkout
     */
    public function checkout(CheckOutRequest $request)
    {

        return $this->borrowBookService->checkout($request);
    }
    /**
     * Checkin
     */
    public function checkin(CheckInRequest $request, string $id)
    {
        return $this->borrowBookService->checkin($request, $id);
    }
    /**
     * Specific User Books
     */
    public function myBooks(Request $request)
    {
        return $this->borrowBookService->mybooks($request);
    }
    /**
     * AllBorrowedBooks
     */
    public function allBooks(Request $request)
    {
        return $this->borrowBookService->allbooks($request);
    }
    /**
     * Search
     */
    public function searchRecords(SearchRequest $request){
        return $this->borrowBookService->searchRecords($request);
    }
    /**
     * GetOverdue
     */
    public function getOverdueBooks(Request $request){
        return $this->borrowBookService->getOverdueBooks($request);
    }
    /**
     * SearchOverdue
     */
    public function searchOverdueBooks(SearchRequest $request){
        return $this->borrowBookService->searchOverdueBooks($request);
    }
}
