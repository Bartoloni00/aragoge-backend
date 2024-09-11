<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Planning;
use App\Models\Subscription;
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

    public function getSubscriptions(int $id)
    {
        $subscriptions = Subscription::getSubscriptionsByUser($id);

        $data = [
            'data' => $subscriptions,
            'status_code' => 200
        ];

        return response()->json($data, 200);
    }

    public function getPlannings(int $id)
    {
        $plannings = Planning::getPlanningsByProfessional($id);

        if ($plannings->count() < 1) $plannings = 'This professional dont have plannigs yet';
        
        $data = [
            'data' => $plannings ,
            'status_code' => 200
        ];

        return response()->json($data, 200);
    }
}
