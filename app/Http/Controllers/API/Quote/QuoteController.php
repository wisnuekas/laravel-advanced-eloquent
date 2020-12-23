<?php

namespace App\Http\Controllers\API\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Quote;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quote = Quote::paginate(10);

        return response()->json($quote, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'start_date' => 'date',
            'end_date' => 'date|after:start_date'
        ]);

        $imageName = time().'.'.$request->image->extension();
        $image_url = '/uploads/quotes/'.$imageName;

        $request->image->move(public_path('/uploads/quotes/'), $imageName);
        
        $data = [
            'title' => $request->title,
            'image' => $image_url,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ];

        $quote = Quote::create($data);

        return response()->json($quote, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quote = Quote::findOrFail($id);

        return response()->json($quote, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|required',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg|max:2048',
            'start_date' => 'date',
            'end_date' => 'date|after:start_date'
        ]);
        
        $quote = Quote::findOrFail($id);

        $quote->update($request->all());

        return response()->json($quote, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quote = Quote::findOrFail($id);

        $quote->delete();

        return response()->json(null, 204);
    }

    public function latest()
    {
        $quote = Quote::latest()->first();

        return response()->json($quote, 200);
    }

    public function image(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $quote = Quote::findOrFail($id);

        $imageName = time().'.'.$request->image->extension();
        $image_url = '/uploads/quotes/'.$imageName;

        $request->image->move(public_path('/uploads/quotes/'), $imageName);
        
        $data = [
            'image' => $image_url,
        ];

        $quote->update($data);

        return response()->json($quote, 201);

    }
}
