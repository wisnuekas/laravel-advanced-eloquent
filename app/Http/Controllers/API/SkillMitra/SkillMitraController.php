<?php

namespace App\Http\Controllers\API\SkillMitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Skill;

class SkillMitraController extends Controller
{
    public function index(Skill $skill)
    {
        $skill_mitra =  $skill->mitras()->where('active', 1)->paginate(10);

        return response()->json($skill_mitra);
    }
}
