<?php

namespace App\Http\Controllers\API\MitraCategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mitra;

class MitraCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Mitra $mitra)
    {
        $mitra_categories = $mitra->categories;

        return response()->json($mitra_categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Mitra $mitra)
    {
        $mitra_categories = $mitra->categories()->sync($request->categories);

        return response()->json($mitra->categories);
    }
}
