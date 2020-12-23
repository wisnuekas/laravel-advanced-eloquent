<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;

class CustomerAddressController extends Controller
{
    public function index(Customer $customer)
    {
        $address = $customer->addresses;

        return response()->json($address, 200);
    }
}
