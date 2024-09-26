<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Planning;
use App\Models\Subscription;
use App\Models\Professional;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function getUsers(Request $request)
    {
        $queryParams = $request->only(['rol']);
        
        if(!empty($queryParams['rol'])){
            $users = User::getAllUsersFiltered($queryParams['rol']);
        } else {
            $users = User::all();
        }
        if($users->count() < 1) return response()->json(['errors' => 'Usuarios no encontrados','status_code' => 404], 404);

        $data = [
            'data' => $users,
            'status_code' => 200
        ];

        return response()->json($data, 200);
    }

    public function getByID(int $id)
    {
        $user = User::getUserByID($id);
        if(!$user) return response()->json(['errors' => 'Usuario no encontrado','status_code' => 404], 404);

        $data = [
            'data' => $user,
            'status_code' => 200
        ];
        
        return response()->json($data, 200);
    }

    public function getSubscriptions(int $id)
    {
        $subscriptions = Subscription::getSubscriptionsByUser($id);

        if ($subscriptions->count() < 1) $subscriptions = 'Este usuario todavia no se ha subscrito a ninguna planificacion.';

        $data = [
            'data' => $subscriptions,
            'status_code' => 200
        ];

        return response()->json($data, 200);
    }

    public function getPlannings(int $id)
    {
        $plannings = Planning::getPlanningsByProfessional($id);

        if ($plannings->count() < 1) $plannings = 'Este profesional todavia no ha creado ninguna planificacion.';
        
        $data = [
            'data' => $plannings ,
            'status_code' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        if(!$user) return response()->json(['errors' => 'Usuario no encontrado','status_code' => 404], 404);

        $request->validate(User::UPDATE_RULES, User::ERROR_MESSAGES);
        $updateUserData = $request->only(['first_name', 'last_name', 'email', 'role_id']);

        $updateUserData['updated_at'] = now();

        $user->update($updateUserData);

        $data = [
            'message' => 'Datos del usuario actualizados exitosamente',
            'data' => $user,
            'status_code' => 200
        ];

        return response()->json($data, 200);
    }

    public function delete(Request $request)
    {
        $user = $request->user();

        try {
            DB::beginTransaction();
            if(!$user) return response()->json(['errors' => 'Usuario no encontrado','status_code' => 404], 404);

            $data = [
                'data' => 'Usuario borrado exitosamente',
                'status_code' => 200
            ];

            if ($user->rol->name == 'professional' && Professional::find($user->professional_id)) {
                $professionalProfile = Professional::find($user->professional_id);

                $user->delete();
                $professionalProfile->delete();
            } else {
                $user->delete();
            }


            DB::commit();

            return response()->json($data, 200);
        }  catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            return response()->json(data: [
                'errors' => 'Ocurrior un error en la base de datos.',
                'message' => $e->getMessage()
            ], status: 500);
        } catch (\Throwable $th) {
            DB::rollBack();
            

            return response()->json(data: [
                'errors' => 'Ocurrio un error inesperado. Por favor, inténtelo de nuevo.',
                'message' => $th->getMessage()
            ], status: 500);
        }
    }
}
