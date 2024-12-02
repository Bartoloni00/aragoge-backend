<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Planning;
use Illuminate\Support\Facades\DB;

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

    public static function getTopSubscribedProfessionals($limit = 10)
    {
        $professionals = User::select('users.*', \DB::raw('COUNT(subscriptions.id) as subscriptions_count'))
            ->join('professionals', 'users.professional_id', '=', 'professionals.id')
            ->join('plannings', 'professionals.id', '=', 'plannings.professional_id')
            ->join('subscriptions', 'plannings.id', '=', 'subscriptions.planning_id')
            ->groupBy('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.created_at',
                      'users.updated_at', 'users.professional_id', 'users.email_verified_at','users.password',
                      'users.remember_token', 'users.image_id', 'users.rol_id')
            ->orderBy('subscriptions_count', 'desc')
            ->limit($limit)
            ->get();
    
        return $professionals;
    }
}
