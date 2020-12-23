<?php

namespace App\Http\Controllers\API\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mitra;

class MitraReviewController extends Controller
{
    public function index(Mitra $mitra)
    {
        $reviews = $mitra->reviews()
                    ->orderBy('created_at', 'DESC')
                    ->paginate(10);

        $average = round($mitra->reviews()->avg('rating'), 1);

        $count = $mitra->reviews()->count();

        return response()->json([
            'average' => $average,
            'count' => $count,
            'paginate' => $reviews
        ], 200);
    }
}
