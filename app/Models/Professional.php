<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use HasFactory;

    protected $appends = ['specialty_name'];

    protected $fillable = [
        'description',
        'synopsis',
        'specialty_id',
        'created_at',
        'updated_at'
    ];

    public const CREATE_RULES = [
        'description' => ['required'],
        'synopsis' => ['required'],
        'specialty_id' => ['required', 'integer', 'in:1,2,3'],
    ];

    public const UPDATE_RULES = [
        'description' => ['string'],
        'synopsis' => ['string'],
        'specialty_id' => ['integer', 'in:1,2,3'],
    ];

    public const ERROR_MESSAGES = [
        'description.required' => 'Descripcion es un campo obligatorio',
        'synopsis.required' => 'Sinopsis es un campo obligatorio',
        'specialty_id.required' => 'La especialidad es un campo obligatorio',
        'specialty_id.integer' => 'La especialidad tiene que tener un valor numerico',
        'specialty_id.in' => 'La especialidad tiene que ser un valor: 1, 2 o 3',
    ];

    public function profession()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }

    public function specialty()
    {
        return $this->belongsTo(Speciality::class, 'specialty_id');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'professional_id');
    }

    public function getSpecialtyNameAttribute()
    {
        return $this->specialty ? $this->specialty->name : null;
    }
}
