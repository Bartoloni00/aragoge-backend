<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

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
        return  ['This professional dont have a profile yet'];
       }
    }
}
