<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasFactory;
    protected $appends = ['professional_name', 'category_name'];

    protected $hidden = ['professional', 'category'];

    protected $fillable = [
        'title',
        'description',
        'synopsis',
        'price',
        'category_id',
        'image_id',
        'professional_id',
        'created_at',
        'updated_at',
    ];

    // professional_id es obligatorio pero ya que lo agregamos utilizando el bearer token no es necesario.
    public const CREATE_RULES = [
        'title' => 'required|string',
        'description' => 'required|string',
        'synopsis' => 'required|string',
        'price' => 'required|numeric',
        'category_id' => 'required|integer',
        'image_id' => 'integer',
    ];

    public const UPDATE_RULES = [
        'title' => 'string',
        'description' => 'string',
        'synopsis' => 'string',
        'price' => 'numeric',
        'category_id' => 'integer',
        'image_id' => 'integer',
    ];

    public const ERROR_MESSAGES = [
        'title.required' => 'El campo "Título" es obligatorio',
        'title.string' => 'El campo "Título" debe ser una cadena de caracteres',
        'description.required' => 'El campo "Descripción" es obligatorio',
        'description.string' => 'El campo "Descripción" debe ser una cadena de caracteres',
        'synopsis.required' => 'El campo "Sinopsis" es obligatorio',
        'synopsis.string' => 'El campo "Sinopsis" debe ser una cadena de caracteres',
        'price.required' => 'El campo "Precio" es obligatorio',
        'price.numeric' => 'El campo "Precio" debe ser un número',
        'category_id.required' => 'El campo "Categoría" es obligatorio',
        'category_id.integer' => 'El campo "Categoría" debe ser un número entero',
        'image_id.integer' => 'El campo "Imagen" debe ser un número entero',
    ];

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
