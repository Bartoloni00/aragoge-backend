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
        'name.required' => 'Name is a required fill',
        'name.max' => "Name max length: 60 ",
        'name.string' => "Name must be an string",
    ];
    
}
