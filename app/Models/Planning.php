<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasFactory;
    protected $appends = ['professional_name', 'category_name'];

    protected $hidden = ['professional', 'category'];

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

    public function getProfessionalNameAttribute()
    {
        $user = $this->professional->user->first();
        return $user ? $user->first_name . ' ' . $user->last_name : null;
    }

    public function getCategoryNameAttribute()
    {
        
        return $this->category ? $this->category->name : null;
    }

    public static function getPlanningsByProfessional(int $id)
    {
        $planningsByProfessional = Planning::whereHas('professional', function($query) use ($id) {
            $query->where('id', $id);
        })
        ->get();

        return $planningsByProfessional;
    }

    public static function getPlanningsByCategoryFiltered($category)
    {
        $planningsByCategory = [];
        
        if(is_numeric($category))
        {
            $planningsByCategory = Planning::whereHas('category', function($query) use ($category) {
                $query->where('id', $category);
            })
            ->get();
        } 
        else if (is_string($category)) 
        {
            $planningsByCategory = Planning::whereHas('category', function($query) use ($category) {
                $query->where('name', $category);
            })
            ->get();
        }

        return $planningsByCategory;
    }
}
