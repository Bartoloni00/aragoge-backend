<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function getRoles()
    {
        $roles = Rol::all();

        $data = [
            'data' => $roles,
            'status_code' => 200
        ];

        return response()->json($data,200);
    }

    public function getRolByID(int $id)
    {
        $rol = Rol::findOrFail($id);

        if (!$rol) {
            return response()->json([
                'errors'=> 'El rol no fue encontrado',
                'status' => 404
            ],404);
        }

        $data = [
            'data' => $rol,
            'status_code' => 200
        ];

        return response()->json($data,200);
    }
}
