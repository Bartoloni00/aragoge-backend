<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function getUsers(Request $request)
    {
        $queryParams = $request->only(['rol']);
        
        if(!empty($queryParams['rol'])){
            $users = User::getAllUsersFiltered($queryParams['rol']);
            if($users->count() < 1) return response()->json(['Error' => 'Users Not Found','status_code' => 404], 404);
        } else {
            $users = User::all();
        }

        $data = [
            'data' => $users,
            'status_code' => 200
        ];

        return response()->json($data, 200);
    }

    public function getByID(int $id)
    {
        $user = User::getUserByID($id);

        $data = [
            'data' => $user,
            'status_code' => 200
        ];
        
        return response()->json($data, 200);
    }
}
