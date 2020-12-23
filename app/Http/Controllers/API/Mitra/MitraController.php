<?php

namespace App\Http\Controllers\API\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MitraRequest;
use App\Mitra;

class MitraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mitra = Mitra::paginate(10);

        return response()->json($mitra, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MitraRequest $request)
    {
        return Mitra::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mitra = Mitra::findOrFail($id);

        return response()->json($mitra, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MitraRequest $request, $id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->update($request->all());

        return response()->json($mitra, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->delete();

        return response()->json(null, 204);
    }
}
