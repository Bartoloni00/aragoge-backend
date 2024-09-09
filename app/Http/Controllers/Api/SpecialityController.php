<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Speciality;
use Illuminate\Http\Request;

class SpecialityController extends Controller
{
    public function all()
    {
        $specialities = Speciality::all();

        $data = [
            'data' => $specialities,
            'status_code' => 200
        ];

        return response()->json($data,200);
    }

    public function getByID(int $id)
    {
        $speciality = Speciality::findOrFail($id);

        $data = [
            'data' => $speciality,
            'status_code' => 200
        ];

        return response()->json($data, 200);
    }
}
