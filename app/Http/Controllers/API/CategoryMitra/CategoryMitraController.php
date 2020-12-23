<?php

namespace App\Http\Controllers\API\CategoryMitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoryMitraController extends Controller
{
    public function index(Category $category)
    {
        $category_mitra =  $category->mitras()->where('active', 1)->paginate(10);

        return response()->json($category_mitra);
    }
}
