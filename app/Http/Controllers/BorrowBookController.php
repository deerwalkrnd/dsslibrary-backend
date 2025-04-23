<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowBookRequest;
use App\Http\Requests\CheckInRequest;
use App\Http\Requests\CheckOutRequest;
use App\Services\BorrowBookService;
use Illuminate\Http\Request;

class BorrowBookController extends Controller
{
    public function __construct(
        protected BorrowBookService $borrowBookService
    ) {
    }
    public function checkout(CheckOutRequest $request)
    {

        return $this->borrowBookService->checkout($request);
    }
    public function checkin(CheckInRequest $request,string $id)
    {
        return $this->borrowBookService->checkin($request,$id);
    }
    public function myBooks(){
        return $this->borrowBookService->mybooks();
    }
    public function allBooks(){
        return $this->borrowBookService->allbooks();
    }
}
