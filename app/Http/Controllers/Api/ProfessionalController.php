<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Professional;

class ProfessionalController extends Controller
{
    public function createProfessionalProfile(Request $request)
    {
        try {
            $user = $request->user();
            $professionalProfileData = $request->only(['description', 'synopsis', 'specialty_id']);

            $request->validate(Professional::CREATE_RULES, Professional::ERROR_MESSAGES);

            $professionalProfileData['created_at'] = now();
            $professionalProfileData['updated_at'] = now(); 

            $professional = Professional::create($professionalProfileData);

            $user->update(['professional_id' => $professional->id]);

            $data = [
                'message' => 'Perfil profesional creado exitosamente',
                'data' => $professional,
                'status_code' => 201
            ];

            return response()->json($data, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => 'Ocurrio un error inesperado. Por favor, inténtelo de nuevo.',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function updateProfessionalProfile(Request $request)
    {
        $user = $request->user();
        $professionalProfileData = $request->only(['description', 'synopsis', 'specialty_id']);

        $request->validate(Professional::UPDATE_RULES, Professional::ERROR_MESSAGES);

        $professionalProfileData['updated_at'] = now();

        $professional = Professional::find($user->professional_id);

        if(!$professional){
            return response()->json([
                'message' => 'El profesional no fue encontrado',
                'status_code' => 404
            ], 404);
        }

        $professional->update($professionalProfileData);

        $data = [
            'message' => 'Perfil profesional editado exitosamente',
            'data' => $professional,
            'status_code' => 200
        ];

        return response()->json($data, 200);
    }
}
