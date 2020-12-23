<?php

namespace App\Http\Controllers\API\Skill;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Skill;

class SkillController extends Controller
{
    public function store(Request $request)
    {
        $skill = Skill::create($request->all());

        return response()->json($skill, 201);
    }

    public function query(Request $request)
    {
        $query = $request->q;
        $skill = Skill::where('name', 'like', '%'.$query.'%')->get();

        return response()->json($skill, 200);
    }
}
