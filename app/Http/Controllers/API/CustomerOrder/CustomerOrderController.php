<?php

namespace App\Http\Controllers\API\CustomerOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;

class CustomerOrderController extends Controller
{
    public function index(Customer $customer)
    {
        $customer->order()->orderBy('updated_at', 'DESC')->paginate(10);

        return response()->json($customer, 200);
    }

    public function processed(Customer $customer)
    {
        $customer->order()->whereNotNull('processed_at')->orderBy('updated_at', 'DESC')->paginate(10);

        return response()->json($customer, 200);
    }

    public function canceled(Customer $customer)
    {
        $customer->order()->whereNotNull('canceled_at')->orderBy('updated_at', 'DESC')->paginate(10);

        return response()->json($customer, 200);    
    }

    public function finished(Customer $customer)
    {
        $customer->order()->whereNotNull('finished_at')->orderBy('updated_at', 'DESC')->paginate(10);

        return response()->json($customer, 200);    
    }
}
