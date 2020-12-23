<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;

class CustomerReviewController extends Controller
{
    public function index(Customer $customer)
    {
        $reviews = $customer->reviews()
                    ->orderBy('created_at', 'DESC')
                    ->paginate(10);

        return response()->json($reviews, 200);
    }
}
