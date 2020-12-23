<?php

namespace App\Http\Controllers\API\MitraSkill;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mitra;

class MitraSkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Mitra $mitra)
    {
        $mitra_skills = $mitra->skills;

        return response()->json($mitra_skills, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Mitra $mitra)
    {
        $mitra_skills = $mitra->skills()->sync($request->skills);

        return response()->json($mitra->skills);
    }
}
