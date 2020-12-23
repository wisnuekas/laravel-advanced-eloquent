<?php

namespace App\Http\Controllers\API\Mitra;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mitra;

class UpdateAvatar extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $this->validate($request, [
            'avatar' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $mitra = Mitra::findOrFail($id);
        $fileUrl = $mitra->saveAvatar($request->avatar);

        $mitra->update([
            'avatar' => $fileUrl
        ]);

        return response()->json($mitra, 200);
    }
}
