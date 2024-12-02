<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Professional;

class ProfessionalController extends Controller
{
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
