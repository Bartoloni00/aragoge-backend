<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function all()
    {
        $categories = Category::all();

        $data = [
            'data' => $categories,
            'status_code' => 200
        ];

        return response()->json($data,200);
    }
}
