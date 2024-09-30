<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Planning;

class ProfessionalUser extends User
{
    use HasFactory;

    protected static function addProfessionalData(User $professional): array
    {
       if ($professional->profession) {
        $user = [];
        $user['description'] = $professional->profession->description;
        $user['synopsis'] = $professional->profession->synopsis;
        $user['specialty_id'] = $professional->profession->specialty_id;
        $user['specialty_name'] = $professional->profession->specialty_name;

        return $user;
       } else {
        return  ['Este usuario todavia no tiene un perfil profesional asignado'];
       }
    }

    public static function isMyPlanning(int $userId, int $planningId)
    {
        $planning = Planning::find($planningId);
        if(!$planning) throw new Exception("La planificacion no fue encontrada", 1);
        
        $user = User::find($userId);
        if($user->profession->id == $planning->professional_id) return true;

        return false;
    }
}
