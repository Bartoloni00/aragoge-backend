<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at'
    ];

    public const CREATE_RULES = [
        'name' => ['required', 'max:60', 'string'],
    ];
    
    public const ERROR_MESSAGES = [
        'name.required' => 'El nombre de un campo obligatorio',
        'name.max' => "El nombre debe contener un maximo de 60 caracteres",
        'name.string' => "El nombre debe ser una cadena de texto",
    ];
    

    public static function isValidCategoryId(int $id)
    {
        $category = Category::find($id);
        if(!$category) return false;
        return true;
    }
}
