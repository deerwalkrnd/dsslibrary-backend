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

    public function checkout(CheckOutRequest $request)
    {

        return $this->borrowBookService->checkout($request);
    }

    public function checkin(CheckInRequest $request, string $id)
    {
        return $this->borrowBookService->checkin($request, $id);
    }

    public function myBooks(Request $request)
    {
        return $this->borrowBookService->mybooks($request);
    }

    public function allBooks(Request $request)
    {
        return $this->borrowBookService->allbooks($request);
    }

    public function searchRecords(SearchRequest $request){
        return $this->borrowBookService->searchRecords($request);
    }

    public function getOverdueBooks(Request $request){
        return $this->borrowBookService->getOverdueBooks($request);
    }

    public function searchOverdueBooks(SearchRequest $request){
        return $this->borrowBookService->searchOverdueBooks($request);
    }
}
