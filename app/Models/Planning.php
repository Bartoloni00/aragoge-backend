<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function image()
    {
        return $this->belongsTo(Planning::class, 'image_id');
    }
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }

    public static function getPlanningsByProfessional(int $id)
    {
        $planningsByProfessional = Planning::whereHas('professional', function($query) use ($id) {
            $query->where('id', $id);
        })
        ->get();

        return $planningsByProfessional;
    }
}
