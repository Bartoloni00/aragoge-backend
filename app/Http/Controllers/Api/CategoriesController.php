<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use DB;
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

    public function getByID(int $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'error'=> 'La categoria no fue encontrada',
                'status' => 404
            ],404);
        }

        $data = [
            'data' => $category,
            'status_code' => 200
        ];

        return response()->json($data,200);
    }

    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $categotyData = $request->only(['name']);

            $request->validate(Category::CREATE_RULES, Category::ERROR_MESSAGES);

            $categotyData['create_at'] = now();
            $categotyData['updated_at'] = now();

            Category::create($categotyData);

            DB::commit();

            return response()->json(data: ['message' => 'La categoria: '. $categotyData['name'] . ' fue agregada exitosamente' ], status: 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(data: [
                'errors' => $e->errors()
            ], status: 422);
    
        } catch (\Throwable $th) {
            DB::rollBack();
    
            return response()->json(data: [
                'message' => 'Ocurrio un error inesperado. Por favor, inténtelo de nuevo.',
                'errors' => $th->getMessage()
            ], status: 500);
        }
    }

    public function delete(int $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'error'=> 'La categoría no fue encontrada',
                'status' => 404
            ],404);
        }

        $category->delete();

        return response()->json([],204);
    }

    public function update(Request $request, int $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'error'=> 'La categoría no fue encontrada',
                'status' => 404
            ],404);
        }

        $categoryData = $request->only(['name']);

        $request->validate(Category::CREATE_RULES, Category::ERROR_MESSAGES);

        $categoryData['updated_at'] = now();

        $category->update($categoryData);

        return response()->json(['Message' => 'La categoria: '. $categoryData['name'] . ' fue editada exitosamente' ], 200);
    }
}
